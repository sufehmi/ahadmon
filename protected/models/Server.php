<?php

/**
 * This is the model class for table "server".
 *
 * The followings are the available columns in table 'server':
 * @property string $id
 * @property string $nama
 * @property string $address
 * @property string $user_name
 * @property string $created_at
 * @property string $updated_at
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property User $updatedBy
 * @property Monitor[] $monitors
 */
class Server extends CActiveRecord {

    // variabel untuk mencari server yang belum dipakai monitorId
    public $monitorId;
    // variabel untuk menghitung summary
    public $filterDari;
    public $filterSampai;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'server';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nama, address, user_name', 'required'),
            array('nama, address', 'length', 'max' => 255),
            array('user_name', 'length', 'max' => 45),
            array('updated_by', 'length', 'max' => 10),
            array('created_at, updated_at, updated_by', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nama, address, user_name, created_at, updated_at, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
            'monitors' => array(self::MANY_MANY, 'Monitor', 'server_monitor(server_id, monitor_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nama' => 'Nama',
            'address' => 'Address',
            'user_name' => 'User Name',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by, true);

        /*
         * Jika monitorId ada
         * Maka hanya tampilkan server yang belum enable untuk monitorId tsb
         */
        if (isset($this->monitorId)) {
            $criteria->join = 'LEFT JOIN server_monitor ON t.id = server_monitor.server_id  and server_monitor.monitor_id=' . $this->monitorId;
            $criteria->addCondition('server_monitor.server_id is null');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.nama'
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Server the static model class
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

    public function afterSave() {
        if ($this->isNewRecord) {
            $this->buatTabelUpTime();
        }
        return parent::afterSave();
    }

    public function buatTabelUpTime() {
        Yii::app()->db->createCommand()
                ->createTable($this->getUptimeTableName(), array(
                    'id' => 'bigint(20) unsigned NOT NULL AUTO_INCREMENT',
                    'result' => 'DECIMAL(9,3) NULL',
                    'waktu' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    'keterangan' => 'varchar(512) DEFAULT NULL',
                    'PRIMARY KEY (`id`)',
                        ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
    }

    public function getUpTimeTableName() {
        return 'uptime_' . $this->id;
    }

    public function ambilDataUpTime() {
        $hasil = Yii::app()->db->createCommand()
                ->select('result')
                ->from($this->getUpTimeTableName())
                ->order('id desc')
                ->limit(50)
                ->queryAll();

        $result = [];
        foreach ($hasil as $row):
            $result[] = $row['result'];
        endforeach;

        $revResult = array_reverse($result);

        return [
            'data' => implode(',', $revResult),
            'terakhir' => end($revResult)
        ];
    }

    public function hapusTabelUptime() {
        Yii::app()->db->createCommand()
                ->dropTable($this->getUptimeTableName());
    }

    public function afterDelete() {
        $this->hapusTabelUptime();
        return parent::afterDelete();
    }

    public function uptimeSummary() {
        $result = Yii::app()->db->createCommand()
                ->select('avg(result) rerata')
                ->from($this->getUpTimeTableName())
                ->where('waktu between :awal and :akhir')
                ->bindValues(array(':awal' => $this->filterDari, ':akhir' => $this->filterSampai))
                ->queryRow();
        $avg = $result['rerata'];

        $result = Yii::app()->db->createCommand()
                ->select('count(*) gagal')
                ->from($this->getUpTimeTableName())
                ->where('waktu between :awal and :akhir and result is null')
                ->bindValues(array(':awal' => $this->filterDari, ':akhir' => $this->filterSampai))
                ->queryRow();
        $gagal = $result['gagal'];

        $result = Yii::app()->db->createCommand()
                ->select('count(*) berhasil')
                ->from($this->getUpTimeTableName())
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
