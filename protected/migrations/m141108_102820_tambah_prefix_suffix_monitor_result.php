<?php

class m141108_102820_tambah_prefix_suffix_monitor_result extends CDbMigration {
    /*
      public function up()
      {
      }

      public function down()
      {
      echo "m141108_102820_tambah_prefix_suffix_monitor_result does not support migration down.\n";
      return false;
      }
     */

    public function safeUp() {
        $this->addColumn('monitor', 'prefix', 'VARCHAR(45) NULL AFTER `view_type_id`');
        $this->addColumn('monitor', 'suffix', 'VARCHAR(45) NULL AFTER `prefix`');
    }

    public function safeDown() {

    }

}
