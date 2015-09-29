<?php

class m150929_033054_tambah_kolom_order_monitor extends CDbMigration {

   public function safeUp() {
      $this->addColumn('monitor', 'order', "INT UNSIGNED NOT NULL DEFAULT 0 AFTER `suffix`");
   }

   public function safeDown() {
      echo "m150929_033054_tambah_kolom_order_monitor does not support migration down.\n";
      return false;
   }

}
