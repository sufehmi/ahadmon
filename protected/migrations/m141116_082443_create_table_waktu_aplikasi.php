<?php

class m141116_082443_create_table_waktu_aplikasi extends CDbMigration {

    public function up() {
        /*
          --
          -- Table structure for table `waktu_aplikasi`
          --
         */
        $this->createTable('waktu_aplikasi', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
            'dari' => 'time NOT NULL',
            'sampai' => 'time NOT NULL',
            'created_at' => "timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'",
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'updated_by' => 'int(10) unsigned NOT NULL',
            'PRIMARY KEY (`id`)',
            'KEY `fk_waktu_applikasi_updatedby_idx` (`updated_by`)'
                ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        /*
          --
          -- Constraints for table `waktu_aplikasi`
          --
         */
        $this->addForeignKey('fk_waktu_applikasi_updatedby', 'waktu_aplikasi', 'updated_by', 'user', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down() {
        echo "m141116_082443_create_table_waktu_aplikasi does not support migration down.\n";
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
