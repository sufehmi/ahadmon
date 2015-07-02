<?php

class DashboardController extends Controller {

	public function actionIndex() {
		$monitorAktif = ServerMonitor::model()->findAll([
			 'select' => 'monitor_id',
			 'distinct' => true,
			 'condition' => 'aktif=1'
		]);

		$servers = Server::model()->findAll([
			 'select' => 'id, nama, address',
			 'order' => 'nama'
		]);

		$dataUptime = [];
		foreach ($servers as $server):
			$curServer = Server::model()->findByPk($server['id']);
			$data = $curServer->ambilDataUptime();
			$dataUptime[$server['id']] = [
				 'data' => $data['data'],
				 'terakhir' => $data['terakhir']
			];
		endforeach;

		$this->render('index', [
			 'monitorAktif' => $monitorAktif,
			 'servers' => $servers,
			 'dataUptime' => $dataUptime
		]);
	}

	public function actionViewUptimeDetail($server_id) {
		$namaTabel = 'uptime_'.$server_id;
		//echo $namaTabel;
		$model = new Uptime($namaTabel);
		$model->scenario = 'search';

		$server = Server::model()->findByPk($server_id);

		$this->render('uptime_detail', [
			 'model' => $model,
			 'server' => $server
		]);
	}

	public function actionUptimeDetailSummary($serverId) {
		if (isset($_POST['Filter'])) {
			$filter = $_POST['Filter'];
			//print_r($filter);
			$server = Server::model()->findByPk($serverId);
			$server->filterDari = $filter['dari'];
			$server->filterSampai = $filter['sampai'];
			$summary = $server->uptimeSummary();
			$gagalPersen = 100;
			if ($summary['berhasil'] > 0) {
				$gagalPersen = $summary['gagal'] / ($summary['berhasil'] + $summary['gagal']) * 100;
			}
			$return = array(
				 'rerata' => number_format($summary['rerata'], 3, ',', '.'),
				 'gagal' => $summary['gagal'],
				 'gagalPersen' => number_format($gagalPersen, 2, ',', '.')
			);
			$this->renderJSON($return);
		}
	}

	public function actionMonitorDetail($id, $serverId) {
		$namaTabel = "{$serverId}_{$id}";
		$model = new MonitorDetail($namaTabel);
		$model->scenario = 'search';

		$monitor = Monitor::model()->findByPk($id);
		$server = Server::model()->findByPk($serverId);

		$this->render('monitor_detail', [
			 'model' => $model,
			 'server' => $server,
			 'monitor' => $monitor
		]);
	}

	public function actionMonitorDetailSummary($monitorId, $serverId) {
		if (isset($_POST['Filter'])) {
			$namaTabel = "{$serverId}_{$monitorId}";
			$filter = $_POST['Filter'];
			//print_r($filter);
			$model = new MonitorDetail($namaTabel);
			$model->filterDari = $filter['dari'];
			$model->filterSampai = $filter['sampai'];
			$summary = $model->detailSummary();
			$gagalPersen = 100;
			if ($summary['berhasil'] > 0) {
				$gagalPersen = $summary['gagal'] / ($summary['berhasil'] + $summary['gagal']) * 100;
			}
			$return = array(
				 'rerata' => number_format($summary['rerata'], 2, ',', '.'),
				 'gagal' => $summary['gagal'],
				 'gagalPersen' => number_format($gagalPersen, 2, ',', '.')
			);
			$this->renderJSON($return);
		}
	}

}
