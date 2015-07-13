<?php

class MonitorController extends Controller {

   /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'ubah' page.
    */
   public function actionTambah() {
      $model = new UploadMonitorForm();
      $monitor = new Monitor;

      // Uncomment the following line if AJAX validation is needed
      // $this->performAjaxValidation($model);
      if (isset($_POST['UploadMonitorForm'])) {
         $scriptFile = CUploadedFile::getInstanceByName('UploadMonitorForm[nama_file]');
         if (isset($scriptFile)) {
            $ini_array = parse_ini_file($scriptFile->tempName, true);

            // echo "Nama: {$ini_array['description']['name']} <br />";
            // echo "Descripsi: {$ini_array['description']['description']} <br />";
            // echo "Perintah: {$ini_array['config']['command']} <br />";
            // echo "Output: {$ini_array['config']['output']} <br />";
            // echo "View: {$ini_array['config']['view']}";
            //$monitor = new Monitor;
            $monitor->nama = $ini_array['description']['name'];
            $monitor->deskripsi = $ini_array['description']['description'];
            $monitor->perintah = $ini_array['config']['command'];
            $monitor->output_type_id = OutputType::model()->find("nama = '{$ini_array['config']['output']}'")->id;
            $monitor->view_type_id = isset($ini_array['config']['view']) ? ViewType::model()->find("nama = '{$ini_array['config']['view']}'")->id : NULL;
            $monitor->prefix = isset($ini_array['config']['prefix']) ? $ini_array['config']['prefix'] : NULL;
            $monitor->suffix = isset($ini_array['config']['suffix']) ? $ini_array['config']['suffix'] : NULL;
            if ($monitor->save()) {
               $this->redirect(array('ubah', 'id' => $monitor->id));
            }
         }
      }

      $this->render('tambah', array(
          'model' => $model,
          'monitor' => $monitor
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

      if (isset($_POST['Monitor'])) {
         $model->attributes = $_POST['Monitor'];
         $model->save();
      }

      $serverBukanList = new Server('search');
      $serverBukanList->unsetAttributes();
      $serverBukanList->monitorId = "={$id}}";

      $serverList = new ServerMonitor('search');
      $serverList->unsetAttributes();
      $serverList->monitor_id = "={$id}}";

      $this->render('ubah', array(
          'model' => $model,
          'serverBukanList' => $serverBukanList,
          'serverList' => $serverList,
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
      $model = new Monitor('search');
      $model->unsetAttributes();  // clear any default values
      if (isset($_GET['Monitor']))
         $model->attributes = $_GET['Monitor'];

      $this->render('index', array(
          'model' => $model,
      ));
   }

   /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer $id the ID of the model to be loaded
    * @return Monitor the loaded model
    * @throws CHttpException
    */
   public function loadModel($id) {
      $model = Monitor::model()->findByPk($id);
      if ($model === null)
         throw new CHttpException(404, 'The requested page does not exist.');
      return $model;
   }

   /**
    * Performs the AJAX validation.
    * @param Monitor $model the model to be validated
    */
   protected function performAjaxValidation($model) {
      if (isset($_POST['ajax']) && $_POST['ajax'] === 'monitor-form') {
         echo CActiveForm::validate($model);
         Yii::app()->end();
      }
   }

   public function actionEnSr($id, $monitorId) {
      if (isset($_GET['monitorId'])) {
         $newPair = new ServerMonitor;
         $newPair->monitor_id = $_GET['monitorId'];
         $newPair->server_id = $_GET['id'];
         $newPair->installMonitor();
      }
   }

   public function actionDelSr($server_id, $monitor_id) {
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
