<?php

$host = 'localhost';
$dbName = 'ahadmon';
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');

$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";

$monitors = array();

try {
	$dbh = new PDO($dsn, MYSQL_USER, MYSQL_PASS);
	/*	 * * echo a message saying we have connected ** */
	echo "Pre Process: Connected to database \n";

	$sql = "SELECT CONCAT(sm.server_id,'_', sm.monitor_id) as namaTabel,
            CONCAT('(ssh ', s.user_name,'@',s.address, ' -o ConnectTimeout=',sm.connection_timeout,' ',m.perintah,') 2>&1') as command,
            sm.interval, s.id as server_id, m.id as monitor_id
            FROM server_monitor sm
            JOIN monitor m on sm.monitor_id = m.id
            JOIN server s on sm.server_id = s.id
            WHERE sm.aktif=1";

	$monitors = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

	$sql = "SELECT id, address "
			  ."FROM server ";

	$servers = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

	/*	 * * close the database connection ** */
	$dbh = null;
} catch (PDOException $e) {
	echo $e->getMessage()."\n";
}


$i = 1;
foreach ($monitors as $monitor):

	//print_r($monitor);

	$pid = pcntl_fork();
	/*
	  if ($pid == -1) {
	  die('could not fork');
	  }
	 */
	if (!$pid) {
		echo 'Executing Child #'.$i."..\n";
		$mon = new Monitor($dsn, $monitor);
		$mon->run();
		exit($i);
	} elseif ($pid) {
		//echo "execute in parent \n";
		//nothing to do
	}
	$i++;
endforeach;

foreach ($servers as $server):

	//print_r($server);

	$pid = pcntl_fork();
	/*
	  if ($pid == -1) {
	  die('could not fork');
	  }
	 */
	if (!$pid) {
		echo 'Executing Child #'.$i."..\n";
		$monitor = array(
			 'namaTabel' => "uptime_{$server['id']}",
		);
		$upTime = new UpTime($dsn, $monitor);
		$upTime->server = $server;
		$upTime->run();
		exit($i);
	} elseif ($pid) {
		//echo "execute in parent \n";
		//nothing to do
	}
	$i++;
endforeach;

while (pcntl_waitpid(0, $status) != -1) {
	$status = pcntl_wexitstatus($status);
	echo "Proses $status completed\n";
}

class BaseMonitor {

	public $dsn;
	public $db;
	public $monitor;
	public $namaTabelNotifikasi = 'notifikasi';
	public $namaTabelNotifBreach = 'notifikasi_breach';
	public $namaTabelNotifikasiAksi = 'notifikasi_aksi';
	private $_namaTabelWaktuAplikasi = 'waktu_aplikasi';

	public function __construct($dsn, $monitor) {
		$this->dsn = $dsn;
		$this->monitor = $monitor;

		try {
			$this->db = new PDO($this->dsn, MYSQL_USER, MYSQL_PASS);
			echo "\nMonitor {$this->monitor['namaTabel']}: Connected to database\n";
		} catch (PDOException $e) {
			echo $e->getMessage()."\n";
		}
	}

	public function __destruct() {
		$this->db = null;
	}

	/**
	 * Cek waktu aplikasi
	 * @return boolean
	 */
	public function dalamWaktuAplikasi() {
		$daftarWaktu = $this->db->query("SELECT dari, sampai FROM {$this->_namaTabelWaktuAplikasi} order by dari")->fetchAll();
		//print_r($daftarWaktu);
		$sekarang = date('H:i:s');

		$boleh = false;
		foreach ($daftarWaktu as $waktu):
			if ($sekarang >= $waktu['dari'] && $sekarang <= $waktu['sampai']):
				$boleh = true;
				break;
			endif;
		endforeach;
		return $boleh;
	}

	public function dalamWaktuServer() {
		
	}

	public function dalamWaktuMonitorServer() {
		
	}

	public function notifikasiAksi($serverId, $monitorId, $subject, $pesan, $value, $id = 1) {
		echo "\nNotifikasi Aksi {$id}, Sr {$serverId}, Mo {$monitorId} \n";
		$notifikasiAksi = $this->db->query("SELECT * FROM {$this->namaTabelNotifikasiAksi} WHERE id={$id}")->fetch(PDO::FETCH_ASSOC);

		$monitor = $this->db->query("SELECT nama FROM monitor WHERE id={$monitorId}")->fetch(PDO::FETCH_ASSOC);
		$server = $this->db->query("SELECT nama FROM server WHERE id={$serverId}")->fetch(PDO::FETCH_ASSOC);

		if ($notifikasiAksi['tipe'] == 1) {
			/* 1 = email */
			$var = array(
				 '{$server}' => $server['nama'],
				 '{$monitor}' => $monitor['nama'],
				 '{$value}' => $value
			);
			$pesanTampil = strtr($pesan, $var);
			$subjectTampil = strtr($subject, $var);
			echo 'Email Send: Subject:'.$subjectTampil.' '.$pesanTampil."\n";

			$to = $notifikasiAksi['kepada'];
			$message = $pesanTampil;
			$headers = 'From: '.$notifikasiAksi['dari']."\r\n".
					  'Reply-To: '.$notifikasiAksi['dari']."\r\n".
					  'X-Mailer: PHP/'.phpversion();

			mail($to, $subjectTampil, $message, $headers);
		}
	}

}

class Monitor extends BaseMonitor {

	public function run() {
		$lastExecute = $this->db->query("SELECT max(waktu) FROM {$this->monitor['namaTabel']}")->fetchColumn();
		$menit = 0;

		if (is_null($lastExecute)) {
			echo "{$this->monitor['namaTabel']} lastExecute null ";
		} else {
			$lastExecuteTime = new DateTime($lastExecute);
			$sekarang = new DateTime;
			$diff = $lastExecuteTime->diff($sekarang);
			printf('Monitor '.$this->monitor['namaTabel'].': %d menit'."\n", $diff->i);
			$menit = $diff->i;
		}

		$dalamInterval = false;

		if ($menit >= $this->monitor['interval'] || is_null($lastExecute)) {
			$dalamInterval = true;
		}

		if ($dalamInterval && $this->dalamWaktuAplikasi()):

			exec($this->monitor['command'], $out);

			/*
			 * Jika di nilai kembalian ada string ssh: berarti ada ssh error
			 */
			if (substr($out[0], 0, 4) == 'ssh:') {
				echo "\nGagal {$this->monitor['namaTabel']}: ".$out[0]."\n";
				try {
					$this->db->exec("INSERT INTO {$this->monitor['namaTabel']} (keterangan) values ('{$out[0]}')");
				} catch (Exception $e) {
					throw $e;
				}
			} else {
				try {
					$berhasil = $this->db->exec("INSERT INTO {$this->monitor['namaTabel']} (result) values ({$out[0]})");

					if ($this->isBreach($this->monitor['server_id'], $this->monitor['monitor_id'], $out[0])) {
						$this->notifikasi($this->monitor['server_id'], $this->monitor['monitor_id'], $out[0]);
					} else {
						echo "\nMonitor {$this->monitor['namaTabel']}: Kondisi OK. Alarm OFF\n";
						$this->db->exec("DELETE FROM {$this->namaTabelNotifBreach} WHERE monitor_id={$this->monitor['monitor_id']} AND server_id={$this->monitor['server_id']}");
					}
					//echo "\nBerhasil {$this->monitor['namaTabel']}: " . $out[0] . "\n";
					if ($berhasil != 1) {
						// Tidak berhasil Insert ke result
						// Insert ke field keterangan
						$this->db->exec("INSERT INTO {$this->monitor['namaTabel']} (keterangan) values ('{$out[0]}')");
					}
				} catch (PDOException $e) {
					echo "An Error occured! : "; //user friendly message
					echo $e->getMessage(); //not user friendly message
				}
			}
		endif;
	}

	function isBreach($serverId, $monitorId, $value) {
		$notifikasi = $this->db->query("SELECT notif_condition1, notif_condition2 FROM {$this->namaTabelNotifikasi} WHERE server_id={$serverId} AND monitor_id={$monitorId} AND status=1")->fetch(PDO::FETCH_ASSOC);
		if ($notifikasi) {
			$query = "SELECT {$value} {$notifikasi['notif_condition1']} {$notifikasi['notif_condition2']} as status \n";
			$breach = $this->db->query($query)->fetch(PDO::FETCH_ASSOC);
			return $breach['status'];
		} else {
			return false;
		}
	}

	function notifikasi($serverId, $monitorId, $value) {
		$notif = $this->db->query("SELECT `interval` FROM {$this->namaTabelNotifikasi} WHERE monitor_id={$monitorId} AND server_id={$serverId}")->fetch(PDO::FETCH_ASSOC);
		$waktuTunggu = $notif['interval']; // menit

		$lastBreach = $this->db->query("SELECT updated_at FROM {$this->namaTabelNotifBreach} WHERE server_id={$serverId} AND monitor_id={$monitorId}")->fetchColumn();
		echo "\nAlarm ON!!. lastAlarm:".$lastBreach."\n";

		if (!($lastBreach)) {
			echo "LAST ALARM NULL!";
			/* Jika belum pernah, tambahkan */
			$this->db->exec("INSERT INTO {$this->namaTabelNotifBreach} (monitor_id, server_id, status, updated_at) values ({$monitorId}, {$serverId}, 0, NULL)");
			$lastBreachTime = new DateTime;
		} else {
			$lastBreachTime = new DateTime($lastBreach);
		}

		$sekarang = new DateTime;
		$diff = $lastBreachTime->diff($sekarang);
		$menit = $diff->i;

		if ($menit >= $waktuTunggu) {
			/* Beraksi */
			$notifikasi = $this->db->query("SELECT * FROM {$this->namaTabelNotifikasi} WHERE monitor_id={$monitorId} AND server_id={$serverId}")->fetch(PDO::FETCH_ASSOC);
			$this->notifikasiAksi($serverId, $monitorId, $notifikasi['pesan_subject'], $notifikasi['pesan'], $value, $notifikasi['aksi_id']);
			// Hapus Record
			$this->db->exec("DELETE FROM {$this->namaTabelNotifBreach} WHERE monitor_id={$monitorId} AND server_id={$serverId}");
		} else {
			// Nothing to do
			echo "\nMonitor:{$this->monitor['namaTabel']}, Alarm ON selama {$menit} menit  \n";
		}
	}

}

class UpTime extends BaseMonitor {

	public $server;
	private $_timer = 9;

	function run() {

		if ($this->dalamWaktuAplikasi()):
			//print_r($this->server);
			$namaTabel = $this->monitor['namaTabel'];

			// Ping selama {$_timer} detik, ambil nilai avg rtt (rata-rata round-trip time) nya
			exec("ping -w {$this->_timer} {$this->server['address']} | grep rtt | awk -F/ '{print $5}'", $output);
			//print_r($output);
			$nilai = empty($output) ? 'NULL' : $output[0];
			/* Jika disconnect jalankan rutin disconnectBreach, jika online, hapus record disconnect */
			if ($nilai === 'NULL') {
				$this->disconnectBreach($this->server['id']);
			} else {
				echo "\nServer Connected!. Breach status OFF\n";
				$this->db->exec("DELETE FROM {$this->namaTabelNotifBreach} WHERE monitor_id=0 AND server_id={$this->server['id']}");
			}

			// Simpan ke database}
			try {
				$this->db->exec("INSERT INTO {$namaTabel} (result) values ({$nilai})");
			} catch (PDOException $e) {
				echo "An Error occured! : "; //user friendly message
				echo $e->getMessage(); //not user friendly message
			}
		endif;
	}

	function disconnectBreach($serverId) {
		$notif = $this->db->query("SELECT `interval` FROM {$this->namaTabelNotifikasi} WHERE monitor_id=0 AND server_id={$serverId}")->fetch(PDO::FETCH_ASSOC);
		$waktuTunggu = $notif['interval']; // menit

		$lastBreach = $this->db->query("SELECT updated_at FROM {$this->namaTabelNotifBreach} WHERE server_id={$serverId} AND monitor_id=0")->fetchColumn();
		echo "\nServer Offline!!. lastBreach:".$lastBreach."\n";

		if (!($lastBreach)) {
			echo "LAST BREACH NULL!";
			/* Jika belum pernah, tambahkan */
			$this->db->exec("INSERT INTO {$this->namaTabelNotifBreach} (monitor_id, server_id, status, updated_at) values (0, {$serverId}, 0, NULL)");
			$lastBreachTime = new DateTime;
		} else {
			$lastBreachTime = new DateTime($lastBreach);
		}

		$sekarang = new DateTime;
		$diff = $lastBreachTime->diff($sekarang);
		//printf('serverId: '.$serverId.' %d menit'."\n", $diff->i);
		$menit = $diff->i;

		if ($menit >= $waktuTunggu) {
			/* Beraksi */
			$notifikasi = $this->db->query("SELECT * FROM {$this->namaTabelNotifikasi} WHERE monitor_id=0 AND server_id={$serverId}")->fetch(PDO::FETCH_ASSOC);
			if ($notifikasi) {
				$this->notifikasiAksi($serverId, 0, $notifikasi['pesan_subject'], $notifikasi['pesan'], 'Disconnected', $notifikasi['aksi_id']);
			}
			
			// Hapus Record
			$this->db->exec("DELETE FROM {$this->namaTabelNotifBreach} WHERE monitor_id=0 AND server_id={$serverId}");
		} else {
			// Nothing to do
			echo "\nUptime: Server ID:{$serverId} offline selama {$menit} menit  \n";
		}
	}

}
