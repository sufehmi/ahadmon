<?php

class m141014_084547_tambah_viewtype_onoffstatus extends CDbMigration {

    public function up() {

        /*
          --
          -- Insert data for table `view_type`
          --
         */
        $this->insert('view_type', array(
            'nama' => 'onoffstatus',
            'updated_by' => '1',
        ));
    }

    public function down() {
        echo "m141014_084547_tambah_viewtype_booleanstatus does not support migration down.\n";
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
