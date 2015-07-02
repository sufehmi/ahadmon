<?php

/**
 * This is the model class for table "notifikasi".
 *
 * The followings are the available columns in table 'notifikasi':
 * @property string $id
 * @property string $monitor_id
 * @property string $server_id
 * @property string $notif_condition1
 * @property string $notif_condition2
 * @property string $pesan
 * @property string $pesan_subject
 * @property string $interval
 * @property string $aksi_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property NotifikasiAksi $aksi
 * @property Monitor $monitor
 * @property Server $server
 * @property User $updatedBy
 */
class Notifikasi extends CActiveRecord {

	const STATUS_STOP = 0;
	const STATUS_AKTIF = 1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'notifikasi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			 array('monitor_id, server_id, notif_condition1, notif_condition2, aksi_id', 'required'),
			 array('status', 'numerical', 'integerOnly' => true),
			 array('monitor_id, server_id, interval, aksi_id, updated_by', 'length', 'max' => 10),
			 array('notif_condition1', 'length', 'max' => 2),
			 array('notif_condition2', 'length', 'max' => 500),
			 array('pesan', 'length', 'max' => 1000),
			 array('pesan_subject', 'length', 'max' => 45),
			 array('created_at, updated_at, updated_by', 'safe'),
			 // The following rule is used by search().
			 // @todo Please remove those attributes that should not be searched.
			 array('id, monitor_id, server_id, notif_condition1, notif_condition2, pesan, pesan_subject, interval, aksi_id, created_at, updated_at, updated_by', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			 'aksi' => array(self::BELONGS_TO, 'NotifikasiAksi', 'aksi_id'),
			 'monitor' => array(self::BELONGS_TO, 'Monitor', 'monitor_id'),
			 'server' => array(self::BELONGS_TO, 'Server', 'server_id'),
			 'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			 'id' => 'ID',
			 'monitor_id' => 'Monitor',
			 'server_id' => 'Server',
			 'notif_condition1' => 'Notif Condition1',
			 'notif_condition2' => 'Notif Condition2',
			 'pesan' => 'Pesan',
			 'pesan_subject' => 'Pesan Subject',
			 'interval' => 'Interval (menit)',
			 'aksi_id' => 'Aksi',
			 'status' => 'Status',
			 'created_at' => 'Created At',
			 'updated_at' => 'Updated At',
			 'updated_by' => 'Updated By',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('monitor_id', $this->monitor_id);
		$criteria->compare('server_id', $this->server_id);
		$criteria->compare('notif_condition1', $this->notif_condition1);
		$criteria->compare('notif_condition2', $this->notif_condition2, true);
		$criteria->compare('pesan', $this->pesan, true);
		$criteria->compare('pesan_subject', $this->pesan_subject, true);
		$criteria->compare('interval', $this->interval, true);
		$criteria->compare('aksi_id', $this->aksi_id);
		$criteria->compare('status', $this->status);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('updated_by', $this->updated_by, true);

		return new CActiveDataProvider($this, array(
			 'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notifikasi the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function beforeSave() {

		if ($this->isNewRecord) {
			$this->created_at = date('Y-m-d H:i:s');
		}
		$this->updated_at = null; // Trigger current timestamp
		$this->updated_by = Yii::app()->user->id;
		return parent::beforeSave();
	}

	public function conditionList() {
		return array('=' => '=', '!=' => '!=', '>' => '>', '<' => '<', '>=' => '>=', '<=' => '<=');
	}

	public function getNamaMonitor() {
		$monitor = Monitor::model()->findByPk($this->monitor_id);
		return $monitor->nama;
	}

	public function getNamaServer() {
		$server = Server::model()->findByPk($this->server_id);
		return $server->nama;
	}

	public function getNamaAksi() {
		$aksi = NotifikasiAksi::model()->findByPk($this->aksi_id);
		return $aksi->nama;
	}

	public function getStatusList() {
		return array('Stop', 'Aktif');
	}

	public function getNamaStatus() {
		$namaStatus = $this->getStatusList();
		return $namaStatus[$this->status];
	}

}
