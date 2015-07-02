<?php

class m141009_225621_init_db_ahadmon extends CDbMigration {
    /*
      public function up()
      {
      }

      public function down()
      {
      echo "m141009_225621_init_db_ahadmon does not support migration down.\n";
      return false;
      }
     */

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp() {

        /*
          --
          -- Table structure for table `monitor`
          --
         */
        $this->createTable('monitor', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'nama' => 'varchar(128) NOT NULL',
            'perintah' => 'varchar(1000) NOT NULL',
            'deskripsi' => 'varchar(1000) NULL',
            'output_type_id' => 'int(10) unsigned NOT NULL',
            'view_type_id' => 'int(10) unsigned NOT NULL',
            'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'updated_by' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`id`)',
            'UNIQUE KEY `nama` (`nama`)',
            'KEY `fk_monitor_viewtype_idx` (`view_type_id`)',
            'KEY `fk_monitor_usr_idx` (`updated_by`)',
            'KEY `fk_monitor_outputtype_idx` (`output_type_id`)'
                ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        /*
          --
          -- Table structure for table `output_type`
          --
         */
        $this->createTable('output_type', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'nama' => 'varchar(45) NOT NULL',
            'table_def' => 'varchar(1000) NOT NULL',
            'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'updated_by' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`id`)',
            'UNIQUE KEY `nama` (`nama`)',
            'KEY `fk_output_type_usr_idx` (`updated_by`)'
                ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');


        /*
          --
          -- Insert data for table `output_type`
          --
         */
        $this->insert('output_type', array(
            'nama' => 'numeric',
            'table_def' => 'INT(11) NULL',
            'updated_by' => '1',
        ));
        $this->insert('output_type', array(
            'nama' => 'string',
            'table_def' => 'VARCHAR(1000) NULL DEFAULT NULL',
            'updated_by' => '1',
        ));
        $this->insert('output_type', array(
            'nama' => 'boolean',
            'table_def' => 'TINYINT(1) NULL',
            'updated_by' => '1',
        ));

        /*
          --
          -- Table structure for table `server`
          --
         */
        $this->createTable('server', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'nama' => 'varchar(255) NOT NULL',
            'address' => 'varchar(255) NOT NULL',
            'user_name' => 'varchar(45) NOT NULL',
            'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'updated_by' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`id`)',
            'UNIQUE KEY `nama` (`nama`)',
            'KEY `fk_server_usr_idx` (`updated_by`)'
                ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        /*
          --
          -- Table structure for table `server_monitor`
          --
         */
        $this->createTable('server_monitor', array(
            'server_id' => 'int(10) unsigned NOT NULL',
            'monitor_id' => 'int(10) unsigned NOT NULL',
            'interval' => "int(11) NOT NULL DEFAULT '1' COMMENT 'menit'",
            'connection_timeout' => "int(11) NOT NULL DEFAULT '10' COMMENT 'detik'",
            'notif_condition1' => "enum('=','!=','>','<','>=','<=') DEFAULT NULL COMMENT 'Kondisi untuk where (operator)'",
            'notif_condition2' => "varchar(255) DEFAULT NULL COMMENT 'Kondisi untuk where (content)'",
            'aktif' => "tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=tidak aktif; 1=aktif'",
            'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'updated_by' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`server_id`,`monitor_id`)',
            'KEY `fk_server_monitor_sc_idx` (`monitor_id`)',
            'KEY `fk_server_monitor_usr_idx` (`updated_by`)'
                ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');


        /*
          --
          -- Table structure for table `view_type`
          --
         */
        $this->createTable('view_type', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'nama' => 'varchar(45) NOT NULL',
            'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'updated_by' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`id`)',
            'UNIQUE KEY `nama` (`nama`)',
            'KEY `fk_view_type_usr_idx` (`updated_by`)'
                ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        /*
          --
          -- Insert data for table `view_type`
          --
         */
        $this->insert('view_type', array(
            'nama' => 'linechart',
            'updated_by' => '1',
        ));
        $this->insert('view_type', array(
            'nama' => 'piechart',
            'updated_by' => '1',
        ));
        $this->insert('view_type', array(
            'nama' => 'barchart',
            'updated_by' => '1',
        ));

        /*
          --
          -- Constraints for table `monitor`
          --
         */
        $this->addForeignKey('fk_monitor_outputtype', 'monitor', 'output_type_id', 'output_type', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_monitor_usr', 'monitor', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_monitor_viewtype', 'monitor', 'view_type_id', 'view_type', 'id', 'NO ACTION', 'NO ACTION');

        /*
          --
          -- Constraints for table `output_type`
          --
         */
        $this->addForeignKey('fk_output_type_usr', 'output_type', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');

        /*
          --
          -- Constraints for table `server`
          --
         */
        $this->addForeignKey('fk_server_usr', 'server', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');

        /*
          --
          -- Constraints for table `server_monitor`
          --
         */
        $this->addForeignKey('fk_server_monitor_mon', 'server_monitor', 'monitor_id', 'monitor', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_server_monitor_sr', 'server_monitor', 'server_id', 'server', 'id', 'NO ACTION', 'NO ACTION');
        $this->addForeignKey('fk_server_monitor_usr', 'server_monitor', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');

        /*
          --
          -- Constraints for table `view_type`
          --
         */
        $this->addForeignKey('fk_view_type_usr', 'view_type', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function safeDown() {
        echo "m141009_225621_init_db_ahadmon does not support migration down.\n";
        return false;
    }

}
