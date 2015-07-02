<?php

class NotifikasiaksiController extends Controller {

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
		$model = new NotifikasiAksi;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['NotifikasiAksi'])) {
			$model->attributes = $_POST['NotifikasiAksi'];
			if ($model->save())
				$this->redirect(array('ubah', 'id' => $model->id));
		}

		$this->render('tambah', array(
			 'model' => $model,
			 'tipeList' => $this->getTipeList()
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

		if (isset($_POST['NotifikasiAksi'])) {
			$model->attributes = $_POST['NotifikasiAksi'];
			$model->save();
//			if ($model->save())
//				$this->redirect(array('view', 'id' => $id));
		}

		$this->render('ubah', array(
			 'model' => $model,
			 'tipeList' => $this->getTipeList()
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
		$model = new NotifikasiAksi('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['NotifikasiAksi']))
			$model->attributes = $_GET['NotifikasiAksi'];

		$this->render('index', array(
			 'model' => $model
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NotifikasiAksi the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = NotifikasiAksi::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NotifikasiAksi $model the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'notifikasi-aksi-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function getTipeList() {
		return array(
			 NotifikasiAksi::TIPE_EMAIL => 'Email'
		);
	}

	public function renderLinkUbah($data) {
		return '<a href="'.Yii::app()->controller->createUrl('ubah', array('id' => $data->id)).'">'.$data->nama.'</a>';
	}

}
