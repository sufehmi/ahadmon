<?php

class ServerController extends Controller {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'ubah' page.
     */
    public function actionTambah() {
        $model = new Server;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Server'])) {
            $model->attributes = $_POST['Server'];
            if ($model->save())
                $this->redirect(array('ubah', 'id' => $model->id));
        }

        $this->render('tambah', array(
            'model' => $model,
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

        if (isset($_POST['Server'])) {
            $model->attributes = $_POST['Server'];
            $model->save();
        }

        $monitorListBukan = new Monitor('search');
        $monitorListBukan->unsetAttributes();
        $monitorListBukan->serverId = $id;

        $monitorList = new ServerMonitor('search');
        $monitorList->unsetAttributes();
        $monitorList->server_id = $id;

        $this->render('ubah', array(
            'model' => $model,
            'monitorListBukan' => $monitorListBukan,
            'monitorList' => $monitorList
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
        $model = new Server('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Server']))
            $model->attributes = $_GET['Server'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Server the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Server::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Server $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'server-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionEnMon($id, $serverId) {
        if (isset($_GET['serverId'])) {
            $newPair = new ServerMonitor;
            $newPair->server_id = $_GET['serverId'];
            $newPair->monitor_id = $_GET['id'];
            $newPair->installMonitor();
        }
    }

    public function actionDelMon($server_id, $monitor_id) {
        $serverMonitor = ServerMonitor::model()->findByPk(array(
            'server_id' => $server_id,
            'monitor_id' => $monitor_id
        ));
        $serverMonitor->uninstallMonitor();
    }

    public function actionUpdateInterval() {
        $return = array('sukses' => false);
        if (isset($_POST['pk'])) {
            $pk = $_POST['pk'];
            $interval = $_POST['value'];
            $serverMonitor = ServerMonitor::model()->findByPk($pk);
            $serverMonitor->interval = $interval;
            if ($serverMonitor->save()) {
                $return = array('sukses' => true);
            }
        }
        echo CJSON::encode($return);
    }

    public function actionUpdateConnectionTimedOut() {
        $return = array('sukses' => false);
        if (isset($_POST['pk'])) {
            $pk = $_POST['pk'];
            $timeOut = $_POST['value'];
            $serverMonitor = ServerMonitor::model()->findByPk($pk);
            $serverMonitor->connection_timeout = $timeOut;
            if ($serverMonitor->save()) {
                $return = array('sukses' => true);
            }
        }
        echo CJSON::encode($return);
    }

}
