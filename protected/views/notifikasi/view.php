<?php
/* @var $this NotifikasiController */
/* @var $model Notifikasi */

$this->breadcrumbs=array(
	'Notifikasis'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Notifikasi', 'url'=>array('index')),
	array('label'=>'Create Notifikasi', 'url'=>array('create')),
	array('label'=>'Update Notifikasi', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Notifikasi', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Notifikasi', 'url'=>array('admin')),
);
?>

<h1>View Notifikasi #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'monitor_id',
		'server_id',
		'notif_condition1',
		'notif_condition2',
		'pesan',
		'pesan_subject',
		'aksi_id',
		'created_at',
		'updated_at',
		'updated_by',
	),
)); ?>
