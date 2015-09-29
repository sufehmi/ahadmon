<?php

class m150929_060554_tambah_view_type_text extends CDbMigration {/*
  public function up()
  {
  }

  public function down()
  {
  echo "m150929_060554_tambah_view_type_text does not support migration down.\n";
  return false;
  }
 */

   // Use safeUp/safeDown to do migration with transaction
   public function safeUp() {
      $this->insert('view_type', array(
          'nama' => 'text',
          'updated_by' => '1',
      ));
   }

   public function safeDown() {
      
   }

}
