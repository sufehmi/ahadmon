<?php

class m141014_093505_ganti_outputtype_tabledeff_boolean extends CDbMigration {

    public function up() {
        $this->update('output_type', array('table_def' => 'TINYINT(1) NOT NULL DEFAULT 0'), 'nama = \'boolean\'');
    }

    public function down() {
        echo "m141014_093505_ganti_outputtype_tabledeff_boolean does not support migration down.\n";
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
