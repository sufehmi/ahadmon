<?php

class m150316_035747_tambah_notifikasi_status extends CDbMigration {
	/*
	  public function up()
	  {
	  }

	  public function down()
	  {
	  echo "m150316_035747_tambah_notifikasi_status does not support migration down.\n";
	  return false;
	  }
	 */

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp() {

		$this->addColumn('notifikasi', 'status', "TINYINT NOT NULL DEFAULT 1 COMMENT '0=stop, 1=aktif' AFTER `aksi_id`");
	}

	public function safeDown() {
		
	}

}
