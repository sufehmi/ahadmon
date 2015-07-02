<?php

class NotifikasiController extends Controller {

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			 'accessControl', // perform access control for CRUD operations
			 'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			 array('deny', // deny guest
				  'users' => array('guest'),
			 ),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view', array(
			 'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'ubah' page.
	 */
	public function actionTambah() {
		$model = new Notifikasi;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Notifikasi'])) {
			$model->attributes = $_POST['Notifikasi'];
			if ($model->save())
				$this->redirect(array('ubah', 'id' => $model->id));
		}

		$this->render('tambah', array(
			 'model' => $model,
			 'serverList' => array(),
			 'conditionList' => $this->getConditionList(),
			 'monitorList' => CHtml::listData(Monitor::model()->findAll(array('select' => 'id, nama', 'order' => 'nama')), 'id', 'nama'),
			 'aksiList' => CHtml::listData(NotifikasiAksi::model()->findAll(array('select' => 'id, nama', 'order' => 'nama')), 'id', 'nama')
		));
	}

	/**
	 * Updates a particular model.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUbah($id) {
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Notifikasi'])) {
			$model->attributes = $_POST['Notifikasi'];
			$model->save();
//			if ($model->save())
//				$this->redirect(array('view', 'id' => $id));
		}

		$monitor = Monitor::model()->findByPk($model->monitor_id);
		$servers = $monitor->listServerAktif();
		$serverList = array();
		foreach ($servers as $server) {
			$serverList[$server['id']] = $server['nama'];
		}
		if ($model->monitor_id == 0) {
			$serverList = $this->getServerList();
		}

		$this->render('ubah', array(
			 'model' => $model,
			 'serverList' => $serverList,
			 'conditionList' => $this->getConditionList(),
			 'monitorList' => CHtml::listData(Monitor::model()->findAll(array('select' => 'id, nama', 'order' => 'nama')), 'id', 'nama'),
			 'aksiList' => CHtml::listData(NotifikasiAksi::model()->findAll(array('select' => 'id, nama', 'order' => 'nama')), 'id', 'nama')
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionHapus($id) {
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex() {
		$model = new Notifikasi('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Notifikasi']))
			$model->attributes = $_GET['Notifikasi'];

		$this->render('index', array(
			 'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Notifikasi the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = Notifikasi::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Notifikasi $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'notifikasi-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function getConditionList() {
		return Notifikasi::model()->conditionList();
	}

	public function getNotifCond1List() {
		$condList = Notifikasi::model()->conditionList();
		$list = array();
		foreach ($condList as $condOperator) {
			$list['='.$condOperator] = $condOperator;
		}
		return $list;
	}

	public function getMonitorList() {
		return CHtml::listData(Monitor::model()->findAll(array('select' => 'id,nama', 'order' => 'nama')), 'id', 'nama');
	}

	public function getServerList() {
		return CHtml::listData(Server::model()->findAll(array('select' => 'id,nama', 'order' => 'nama')), 'id', 'nama');
	}

	public function getAksiList() {
		return CHtml::listData(NotifikasiAksi::model()->findAll(array('select' => 'id,nama', 'order' => 'nama')), 'id', 'nama');
	}

	public function actionLoadServer() {
		if (!empty($_POST['Notifikasi']['monitor_id']) || $_POST['Notifikasi']['monitor_id'] == '0') {
			$monitorId = $_POST['Notifikasi']['monitor_id'];
			if ($monitorId == 0) {
				/* Untuk uptime monitor, tampilkan semua server */
				$servers = CHtml::listData(Server::model()->findAll(array('select' => 'id, nama', 'order' => 'nama')), 'id', 'nama');
				foreach ($servers as $id => $nama) {
					echo CHtml::tag('option', array('value' => $id), CHtml::encode($nama), true);
				}
			} else {
				$monitor = Monitor::model()->findByPk($monitorId);
				$servers = $monitor->listServerAktif();
				foreach ($servers as $server) {
					echo CHtml::tag('option', array('value' => $server['id']), CHtml::encode($server['nama']), true);
				}
			}
		} else {
			echo CHtml::tag('option', array('value' => ''), CHtml::encode('Pilih monitor..'), true);
		}
	}

	public function renderLinkUbah($data) {
		return '<a href="'.Yii::app()->controller->createUrl('ubah', array('id' => $data->id)).'">'.$data->id.'</a>';
	}

}
