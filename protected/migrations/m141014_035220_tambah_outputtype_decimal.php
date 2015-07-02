<?php

class m141014_035220_tambah_outputtype_decimal extends CDbMigration {

    public function up() {

        /*
          --
          -- Insert data for table `output_type`
          --
         */
        $this->insert('output_type', array(
            'nama' => 'decimal',
            'table_def' => 'DECIMAL(18,2) NULL',
            'updated_by' => '1',
        ));
    }

    public function down() {
        echo "m141014_035220_tambah_outputtype_decimal does not support migration down.\n";
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
