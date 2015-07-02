<?php

/**
 * This is the model class for table "notifikasi_aksi".
 *
 * The followings are the available columns in table 'notifikasi_aksi':
 * @property integer $id
 * @property string $nama
 * @property integer $tipe
 * @property string $kepada
 * @property string $dari
 * @property string $created_at
 * @property string $updated_at
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property Notifikasi[] $notifikasis
 * @property User $updatedBy
 */
class NotifikasiAksi extends CActiveRecord {

	const TIPE_EMAIL = 1;

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'notifikasi_aksi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
		return array(
			 array('nama, kepada, dari', 'required'),
			 array('tipe', 'numerical', 'integerOnly' => true),
			 array('nama', 'length', 'max' => 45),
			 array('kepada, dari', 'length', 'max' => 500),
			 array('updated_by', 'length', 'max' => 10),
			 array('created_at, updated_at, updated_by', 'safe'),
			 // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
			 array('id, nama, tipe, kepada, dari, created_at, updated_at, updated_by', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
		return array(
			 'notifikasis' => array(self::HAS_MANY, 'Notifikasi', 'aksi_id'),
			 'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			 'id' => 'ID',
			 'nama' => 'Nama',
			 'tipe' => 'Tipe',
			 'kepada' => 'Kepada',
			 'dari' => 'Dari',
			 'created_at' => 'Created At',
			 'updated_at' => 'Updated At',
			 'updated_by' => 'Updated By',
			 'namaTipe' => 'Tipe'
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
		$criteria->compare('nama', $this->nama, true);
		$criteria->compare('tipe', $this->tipe);
		$criteria->compare('kepada', $this->kepada, true);
		$criteria->compare('dari', $this->dari, true);
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
	 * @return NotifikasiAksi the static model class
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

	public function getNamaTipe() {
		$namaTipe = array(self::TIPE_EMAIL => 'Email');
		return $namaTipe[$this->tipe];
	}

}
