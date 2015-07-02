<?php
/* @var $this NotifikasiaksiController */
/* @var $model NotifikasiAksi */

$this->breadcrumbs=array(
	'Notifikasi Aksis'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NotifikasiAksi', 'url'=>array('index')),
	array('label'=>'Create NotifikasiAksi', 'url'=>array('create')),
	array('label'=>'Update NotifikasiAksi', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NotifikasiAksi', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NotifikasiAksi', 'url'=>array('admin')),
);
?>

<h1>View NotifikasiAksi #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nama',
		'tipe',
		'kepada',
		'dari',
		'created_at',
		'updated_at',
		'updated_by',
	),
)); ?>
