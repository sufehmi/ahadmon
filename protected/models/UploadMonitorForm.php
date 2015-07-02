<?php

/**
 * UploadMonitor class.
 * UploadMonitor is the data structure for keeping
 * uploaded form data. It is used by the 'tambah' action of 'MonitorController'.
 */
class UploadMonitorForm extends CFormModel {

    /**
      Declares the validation rules.
     */
    public function rules() {
        return array(
            array('nama_file', 'file',
                'safe' => true,
                'allowEmpty' => true,
                'types' => 'ini',
            //'maxSize' => (1024 * 300), // 300 Kb
            ),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'nama_file' => 'Pilih File',
        );
    }

}
