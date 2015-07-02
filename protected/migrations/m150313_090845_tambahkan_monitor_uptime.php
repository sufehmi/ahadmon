<?php

class m150313_090845_tambahkan_monitor_uptime extends CDbMigration {
	/*
	  public function up()
	  {
	  }

	  public function down()
	  {
	  echo "m150313_090845_tambahkan_monitor_uptime does not support migration down.\n";
	  return false;
	  }
	 */

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp() {
		/*
		  --
		  -- Insert uptime monitor
		  --
		 */
		$this->insert('monitor', array(
			 'nama' => 'Uptime',
			 'perintah' => 'ping',
			 'output_type_id' => '1',
			 'view_type_id' => '1',
			 'created_at' => 'now()',
			 'updated_at' => NULL,
			 'updated_by' => '1',
		));

		/*
		 * 
		  Ubah id jadi 0;
		 */
		$this->execute("update monitor set id=0 where nama='Uptime'");
		//$this->update('monitor', array('id' => '0'), array('nama' => 'Uptime'));
	}

	public function safeDown() {
		
	}

}
