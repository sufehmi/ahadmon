<?php

/**
 * This is the model class for table "monitor".
 *
 * The followings are the available columns in table 'monitor':
 * @property string $id
 * @property string $nama
 * @property string $perintah
 * @property string $deskripsi
 * @property string $output_type_id
 * @property string $view_type_id
 * @property string $prefix
 * @property string $suffix
 * @property string $created_at
 * @property string $updated_at
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property OutputType $outputType
 * @property User $updatedBy
 * @property ViewType $viewType
 * @property Server[] $servers
 */
class Monitor extends CActiveRecord {

	public $outputTypeName;
	public $viewTypeName;
	// variabel untuk mencari monitor yang belum dipakai serverId
	public $serverId;

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'monitor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			 array('nama, perintah, deskripsi, output_type_id, view_type_id', 'required'),
			 array('nama', 'length', 'max' => 255),
			 array('perintah, deskripsi', 'length', 'max' => 1000),
			 array('output_type_id, view_type_id, updated_by', 'length', 'max' => 10),
			 array('prefix, suffix', 'length', 'max' => 45),
			 array('created_at, updated_at, updated_by', 'safe'),
			 // The following rule is used by search().
			 // @todo Please remove those attributes that should not be searched.
			 array('id, nama, perintah, deskripsi, output_type_id, view_type_id, created_at, updated_at, updated_by,outputTypeName, viewTypeName', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			 'outputType' => array(self::BELONGS_TO, 'OutputType', 'output_type_id'),
			 'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
			 'viewType' => array(self::BELONGS_TO, 'ViewType', 'view_type_id'),
			 'servers' => array(self::MANY_MANY, 'Server', 'server_monitor(monitor_id, server_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			 'id' => 'ID',
			 'nama' => 'Nama',
			 'perintah' => 'Perintah',
			 'deskripsi' => 'Deskripsi',
			 'output_type_id' => 'Output Type',
			 'view_type_id' => 'View Type',
			 'prefix' => 'Prefix',
			 'suffix' => 'Suffix',
			 'created_at' => 'Created At',
			 'updated_at' => 'Updated At',
			 'updated_by' => 'Updated By',
			 'outputTypeName' => 'Output',
			 'viewTypeName' => 'View',
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

		$criteria->compare('id', $this->id, true);
		$criteria->compare('nama', $this->nama, true);
		$criteria->compare('perintah', $this->perintah, true);
		$criteria->compare('deskripsi', $this->deskripsi, true);
		$criteria->compare('output_type_id', $this->output_type_id, true);
		$criteria->compare('view_type_id', $this->view_type_id, true);
		$criteria->compare('prefix', $this->prefix, true);
		$criteria->compare('suffix', $this->suffix, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('updated_by', $this->updated_by, true);

		$criteria->with = array('outputType', 'viewType');
		$criteria->compare('outputType.nama', $this->outputTypeName, true);
		$criteria->compare('viewType.nama', $this->viewTypeName, true);
		
		$criteria->addCondition('t.id>0');

		/*
		 * Jika serverId ada
		 * Maka hanya tampilkan monitor yang belum enable untuk serverId tsb
		 */
		if (isset($this->serverId)) {
			$criteria->join = 'LEFT JOIN server_monitor ON t.id = server_monitor.monitor_id  and server_monitor.server_id='.$this->serverId;
			$criteria->addCondition('server_monitor.monitor_id is null');
		}

		return new CActiveDataProvider($this, array(
			 'criteria' => $criteria,
			 'sort' => array(
				  'attributes' => array(
						'outputTypeName' => array(
							 'asc' => 'outputType.nama',
							 'desc' => 'outputType.nama desc'
						),
						'viewTypeName' => array(
							 'asc' => 'viewType.nama',
							 'desc' => 'viewType.nama desc'
						),
						'*'
				  )
			 )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Monitor the static model class
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

	public function listServerAktif() {
		$query = Yii::app()->db->createCommand()
				  ->select('sr.id, sr.nama')
				  ->from(ServerMonitor::model()->tableName().' sm')
				  ->join(Server::model()->tableName().' sr', 'sm.server_id=sr.id')
				  ->where('monitor_id=:monitorId and aktif=1', array(':monitorId' => $this->id))
				  ->queryAll();
		return $query;
	}

}
