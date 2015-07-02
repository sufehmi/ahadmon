<?php

class m141210_043916_create_table_allowed_ip extends CDbMigration {

    public function up() {
        /*
          --
          -- Table structure for table `allowed_ip`
          --
         */
        $this->createTable('allowed_ip', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'ip_address' => 'varchar(45) NOT NULL',
            'nama' => 'varchar(255) DEFAULT NULL',
            'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'updated_by' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`id`)',
            'UNIQUE KEY `ip_address` (`ip_address`)',
            'KEY `fk_allowed_ip_updatedby_idx` (`updated_by`)'
                ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        /*
          --
          -- Constraints for table `allowed_ip`
          --
         */
        $this->addForeignKey('fk_allowed_ip_updatedby', 'allowed_ip', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');


        /*
          --
          -- Insert init data for table `allowed_ip`
          --
         */
        $this->insert('allowed_ip', array(
            'ip_address' => '*',
            'nama' => 'Allow All',
            'updated_by' => '1',
        ));
    }

    public function down() {
        echo "m141210_043916_create_table_allowed_ip does not support migration down.\n";
        return false;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
