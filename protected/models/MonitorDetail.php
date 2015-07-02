<?php

/**
 * This is the model class for table "$serverId_$monitorId".
 *
 * The followings are the available columns in table '$serverId_$monitorId':
 * @property string $id
 * @property integer $result
 * @property string $waktu
 * @property string $keterangan
 */
class MonitorDetail extends CActiveRecord {

	// variabel untuk menghitung summary
	public $filterDari;
	public $filterSampai;
	// nama tabel dynamic
	private static $_tableName;

	public function __construct($tableName) {
		if (strlen($tableName) == 0) {
			return false;
		}

		if (strlen($tableName) > 0) {
			self::$_tableName = $tableName;
		}

		self::setIsNewRecord(true);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Uptime the static model class
	 */
	public static function model($tableName) {
		if (strlen($tableName) == 0) {
			return false;
		}

		$className = __CLASS__;

		if (strlen($tableName) > 0) {
			self::$_tableName = $tableName;
		}

		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return ''.self::$_tableName.'';
	}

	public function setTableName($tableName) {
		self::$_tableName = $tableName;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			 array('waktu', 'required'),
			 array('result', 'numerical', 'integerOnly' => true),
			 array('keterangan', 'length', 'max' => 512),
			 // The following rule is used by search().
			 // @todo Please remove those attributes that should not be searched.
			 array('id, result, waktu, keterangan', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			 'id' => 'ID',
			 'result' => 'Result',
			 'waktu' => 'Waktu',
			 'keterangan' => 'Keterangan',
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
		$criteria->compare('result', $this->result);
		$criteria->compare('waktu', $this->waktu, true);
		$criteria->compare('keterangan', $this->keterangan, true);

		return new CActiveDataProvider($this, array(
			 'criteria' => $criteria,
			 'sort' => array(
				  'defaultOrder' => 'id desc'
			 )
		));
	}

	public function beforeSave() {

		if ($this->isNewRecord) {
			$this->created_at = date('Y-m-d H:i:s');
		}
		$this->updated_at = null; // Trigger current timestamp
		$this->updated_by = Yii::app()->user->id;
		return parent::beforeSave();
	}

	public function detailSummary() {
		$result = Yii::app()->db->createCommand()
				  ->select('avg(result) rerata')
				  ->from($this->tableName())
				  ->where('waktu between :awal and :akhir')
				  ->bindValues(array(':awal' => $this->filterDari, ':akhir' => $this->filterSampai))
				  ->queryRow();
		$avg = $result['rerata'];

		$result = Yii::app()->db->createCommand()
				  ->select('count(*) gagal')
				  ->from($this->tableName())
				  ->where('waktu between :awal and :akhir and result is null')
				  ->bindValues(array(':awal' => $this->filterDari, ':akhir' => $this->filterSampai))
				  ->queryRow();
		$gagal = $result['gagal'];

		$result = Yii::app()->db->createCommand()
				  ->select('count(*) berhasil')
				  ->from($this->tableName())
				  ->where('waktu between :awal and :akhir and result is not null')
				  ->bindValues(array(':awal' => $this->filterDari, ':akhir' => $this->filterSampai))
				  ->queryRow();
		$berhasil = $result['berhasil'];

		$return = array(
			 'rerata' => $avg,
			 'gagal' => $gagal,
			 'berhasil' => $berhasil
		);

		return $return;
	}

}
