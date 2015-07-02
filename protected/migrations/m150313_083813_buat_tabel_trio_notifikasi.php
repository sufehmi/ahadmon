<?php

class m150313_083813_buat_tabel_trio_notifikasi extends CDbMigration {
	/*
	  public function up() {

	  }

	  public function down() {
	  echo "m150313_083813_buat_tabel_trio_notifikasi does not support migration down.\n";
	  return false;
	  }
	 */

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp() {

		/*
		  --
		  -- Table structure for table `notifikasi`
		  --
		 */
		$this->createTable('notifikasi', array(
			 'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			 'monitor_id' => 'int(10) unsigned NOT NULL',
			 'server_id' => 'int(10) unsigned NOT NULL',
			 'notif_condition1' => "enum('=','!=','>','<','>=','<=') NOT NULL",
			 'notif_condition2' => "varchar(500) NOT NULL",
			 'pesan' => 'varchar(1000) DEFAULT \'Monitor: {$monitor}, Server: {$server}, Value: {$value}\'',
			 'pesan_subject' => "varchar(45) DEFAULT 'Ahadmon Notifikasi'",
			 'interval' => "int(10) unsigned NOT NULL DEFAULT '0'",
			 'aksi_id' => "int(10) unsigned NOT NULL",
			 'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
			 'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			 'updated_by' => 'int(10) unsigned NOT NULL',
			 'PRIMARY KEY (`id`)',
			 'KEY `fk_notifikasi_usr_idx` (`updated_by`)',
			 'KEY `fk_notifikasi_server_idx` (`server_id`)',
			 'KEY `fk_notifikasi_monitor_idx` (`monitor_id`)',
			 'KEY `fk_notifikasi_aksi_idx` (`aksi_id`)',
				  ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		/*
		  --
		  -- Table structure for table `notifikasi_aksi`
		  --
		 */
		$this->createTable('notifikasi_aksi', array(
			 'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			 'nama' => 'varchar(45) NOT NULL',
			 'tipe' => "tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=email'",
			 'kepada' => "varchar(500) NOT NULL",
			 'dari' => "varchar(500) NOT NULL",
			 'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
			 'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			 'updated_by' => 'int(10) unsigned NOT NULL',
			 'PRIMARY KEY (`id`)',
			 'KEY `fk_notifikasi_aksi_usr_idx` (`updated_by`)',
				  ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		/*
		  --
		  -- Table structure for table `notifikasi_breach`
		  --
		 */
		$this->createTable('notifikasi_breach', array(
			 'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
			 'monitor_id' => 'int(10) unsigned NOT NULL',
			 'server_id' => 'int(10) unsigned NOT NULL',
			 'status' => "tinyint(3) unsigned NOT NULL COMMENT '0=breach, 1=sent'",
			 'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			 'PRIMARY KEY (`id`)',
			 'KEY `fk_notifikasi_breach_server_id_idx` (`server_id`)',
			 'KEY `fk_notifikasi_breach_monitor_idx` (`monitor_id`)',
				  ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		/*
		  --
		  -- Constraints for table `notifikasi`
		  --
		 */
		$this->addForeignKey('fk_notifikasi_aksi', 'notifikasi', 'aksi_id', 'notifikasi_aksi', 'id', 'NO ACTION', 'NO ACTION');
		$this->addForeignKey('fk_notifikasi_monitor', 'notifikasi', 'monitor_id', 'monitor', 'id', 'NO ACTION', 'NO ACTION');
		$this->addForeignKey('fk_notifikasi_server', 'notifikasi', 'server_id', 'server', 'id', 'NO ACTION', 'NO ACTION');
		$this->addForeignKey('fk_notifikasi_usr', 'notifikasi', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');

		/*
		  --
		  -- Constraints for table `notifikasi_aksi`
		  --
		 */
		$this->addForeignKey('fk_notifikasi_aksi_usr', 'notifikasi_aksi', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');

		/*
		  --
		  -- Constraints for table `notifikasi_breach`
		  --
		 */
		$this->addForeignKey('fk_notifikasi_breach_monitor', 'notifikasi_breach', 'monitor_id', 'monitor', 'id', 'NO ACTION', 'NO ACTION');
		$this->addForeignKey('fk_notifikasi_breach_server', 'notifikasi_breach', 'server_id', 'server', 'id', 'NO ACTION', 'NO ACTION');
	}

	public function safeDown() {
		
	}

}
