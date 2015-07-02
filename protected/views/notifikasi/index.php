<?php
/* @var $this NotifikasiController */
/* @var $model Notifikasi */

$this->breadcrumbs = array(
	 'Notifikasis' => array('index'),
	 'Manage',
);

$this->menu = array(
	 array('label' => 'List Notifikasi', 'url' => array('index')),
	 array('label' => 'Create Notifikasi', 'url' => array('create')),
);
?>

<div class="row">
	<div class="small-12 columns">
		<div class="block">
			<div class="top-bar block-header">
				<ul class="title-area">
					<li class="name"><h1>Notifikasi</h1></li>
				</ul>
				<section class="top-bar-section">
					<ul class="right">
						<li class="divider"></li>
						<li class="has-form hide-for-small-only">
							<a class="button" accesskey="t" href="<?php echo $this->createUrl('tambah'); ?>"><i class="fa fa-plus"></i> <span class="ak">T</span>ambah</a>
						</li>
						<li class="has-form show-for-small-only">
							<a class="button"  accesskey="t" href="<?php echo $this->createUrl('tambah'); ?>"><i class="fa fa-plus"></i></a>
						</li>
					</ul>
				</section>
			</div>
			<div class="block-content">
				<?php
				$this->widget('BGridView', array(
					 'id' => 'notifikasi-grid',
					 'dataProvider' => $model->search(),
					 'filter' => $model,
					 'columns' => array(
						  // 'id',
						  array(
								'class' => 'BDataColumn',
								'name' => 'id',
								'header' => '<span class="ak">I</span>D',
								'accesskey' => 'i',
								'type' => 'raw',
								'value' => array($this, 'renderLinkUbah')
						  ),
						  array(
								'name' => 'monitor_id',
								'filter' => $this->getMonitorList(),
								'value' => '$data->namaMonitor',
						  ),
						  array(
								'name' => 'server_id',
								'filter' => $this->getServerList(),
								'value' => '$data->namaServer',
						  ),
						  array(
								'name' => 'notif_condition1',
								'filter' => $this->getNotifCond1List(),
						  ),
						  'notif_condition2',
						  'pesan',
						  'pesan_subject',
						  array(
								'name' => 'aksi_id',
								'filter' => $this->getAksiList(),
								'value' => '$data->namaAksi'
						  ),
						  'interval',
						  array(
								'name' => 'status',
								'value' => '$data->namaStatus',
								'filter'=> $model->getStatusList()
						  ),
						  /*
							 'created_at',
							 'updated_at',
							 'updated_by',
							*/
						  array(
								'class' => 'BButtonColumn',
						  ),
					 ),
				));
				?>

			</div>
		</div>
	</div>
</div>