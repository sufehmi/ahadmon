<?php

/**
 * This is the model class for table "uptime_*".
 *
 * The followings are the available columns in table 'uptime_*':
 * @property string $id
 * @property string $result
 * @property string $waktu
 * @property string $keterangan
 */
class Uptime extends CActiveRecord {

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
        return '' . self::$_tableName . '';
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
            array('result', 'length', 'max' => 9),
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
        $criteria->compare('result', $this->result, true);
        $criteria->compare('waktu', $this->waktu, true);
        $criteria->compare('keterangan', $this->keterangan, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id desc'
            )
        ));
    }

    public function afterFind() {
        $this->result = is_null($this->result) ? NULL : number_format($this->result, 3, ',', '.');
        return parent::afterFind();
    }

}
