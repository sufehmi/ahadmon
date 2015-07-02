<?php

/**
 * This is the model class for table "server_monitor".
 *
 * The followings are the available columns in table 'server_monitor':
 * @property string $server_id
 * @property string $monitor_id
 * @property integer $interval
 * @property integer $connection_timeout
 * @property string $notif_condition1
 * @property string $notif_condition2
 * @property integer $aktif
 * @property string $created_at
 * @property string $updated_at
 * @property string $updated_by
 */
class ServerMonitor extends CActiveRecord {

    public $namaMonitor;
    public $namaServer;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'server_monitor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('server_id, monitor_id', 'required'),
            array('interval, connection_timeout, aktif', 'numerical', 'integerOnly' => true),
            array('server_id, monitor_id, updated_by', 'length', 'max' => 10),
            array('notif_condition1', 'length', 'max' => 2),
            array('notif_condition2', 'length', 'max' => 255),
            array('created_at, updated_at, updated_by', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('server_id, monitor_id, interval, connection_timeout, notif_condition1, notif_condition2, aktif, created_at, updated_at, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'server' => array(self::BELONGS_TO, 'Server', 'server_id'),
            'monitor' => array(self::BELONGS_TO, 'Monitor', 'monitor_id'),
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'server_id' => 'Server',
            'monitor_id' => 'Monitor',
            'interval' => 'Interval (Mnt)',
            'connection_timeout' => 'Connection Timeout (dtk)',
            'notif_condition1' => 'Notif Condition1',
            'notif_condition2' => 'Notif Condition2',
            'aktif' => 'Aktif',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'namaMonitor' => 'Monitor',
            'namaServer' => 'Server'
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

        $criteria->compare('server_id', $this->server_id, true);
        $criteria->compare('monitor_id', $this->monitor_id, true);
        $criteria->compare('interval', $this->interval);
        $criteria->compare('connection_timeout', $this->connection_timeout);
        $criteria->compare('notif_condition1', $this->notif_condition1, true);
        $criteria->compare('notif_condition2', $this->notif_condition2, true);
        $criteria->compare('aktif', $this->aktif);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('updated_by', $this->updated_by, true);

        $criteria->with = array('monitor', 'server');
        $criteria->compare('monitor.nama', $this->namaMonitor, true);
        $criteria->compare('server.nama', $this->namaServer, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'namaMonitor' => array(
                        'asc' => 'monitor.nama',
                        'desc' => 'monitor.nama desc'
                    ),
                    'namaServer' => array(
                        'asc' => 'server.nama',
                        'desc' => 'server.nama desc'
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
     * @return ServerMonitor the static model class
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

    public function primaryKey() {
        return array('server_id', 'monitor_id');
    }

    public function installMonitor() {
        $monitor = Monitor::model()->findByPk($this->monitor_id);
        $resultTableDef = $monitor->outputType->table_def;

        $transaction = $this->dbConnection->beginTransaction();
        try {
            if ($this->save()) {
                Yii::app()->db->createCommand()
                        ->createTable($this->getResultTableName(), array(
                            'id' => 'bigint(20) unsigned NOT NULL AUTO_INCREMENT',
                            'result' => $resultTableDef,
                            'waktu' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                            'keterangan' => 'varchar(512) DEFAULT NULL',
                            'PRIMARY KEY (`id`)',
                                ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
                );
                $transaction->commit();
                return true;
            }
            else {
                throw new Exception("Gagal Install Monitor");
            }
        }
        catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function uninstallMonitor() {

        $transaction = $this->dbConnection->beginTransaction();
        try {
            if ($this->delete()) {
                Yii::app()->db->createCommand()
                        ->dropTable($this->getResultTableName());
                $transaction->commit();
                return true;
            }
            else {
                throw new Exception("Gagal Uninstall Monitor");
            }
        }
        catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function getResultTableName() {
        return $this->server_id . '_' . $this->monitor_id;
    }

    public function ambilDataTerakhir($serverId, $monitorId, $qty) {
        try {
            $hasil = Yii::app()->db->createCommand()
                    ->select("IFNULL(result,'null') result")
                    ->from("{$serverId}_$monitorId")
                    ->order('id desc')
                    ->limit($qty)
                    ->queryAll();
            $result = array();
            foreach ($hasil as $row):
                $result[] = $row['result'];
            endforeach;
            return implode(',', array_reverse($result));
        }
        catch (Exception $exc) {
            //echo $exc->getTraceAsString();
        }
    }

    public function ambilServers($monitorId) {
        return $this->with('server')->findAll(array(
                    'condition' => 'aktif=1 and monitor_id=' . $monitorId,
                    'order' => 'server.nama'
        ));
    }

}
