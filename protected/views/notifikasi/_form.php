<?php
/* @var $this NotifikasiController */
/* @var $model Notifikasi */
/* @var $form CActiveForm */
?>

<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		 'id' => 'notifikasi-form',
		 // Please note: When you enable ajax validation, make sure the corresponding
		 // controller action is handling ajax validation correctly.
		 // There is a call to performAjaxValidation() commented in generated controller code.
		 // See class documentation of CActiveForm for details on this.
		 'enableAjaxValidation' => false,
	));
	?>

	<?php echo $form->errorSummary($model, 'Error: Perbaiki input', null, array('class' => 'panel callout')); ?>

	<div class="row">
		<div class="small-12 columns">
			<?php echo $form->labelEx($model, 'monitor_id'); ?>
			<?php
			echo $form->dropDownList($model, 'monitor_id', $monitorList, array(
				 'ajax' => array(
					  'type' => 'POST', //request type
					  'url' => $this->createUrl('loadServer'), //url to call.
					  //Style: CController::createUrl('currentController/methodToCall')
					  'update' => '#server', //selector to update
					  //'data'=>'js:javascript statement' 
					  //leave out the data key to pass all form values through
					  'data' => array('Notifikasi[monitor_id]' => 'js:this.value'),
				 ),
				 'prompt' => 'Pilih satu..')
			);
			?>
			<?php echo $form->error($model, 'monitor_id', array('class' => 'error')); ?>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<?php echo $form->labelEx($model, 'server_id'); ?>
			<?php echo $form->dropDownList($model, 'server_id', $serverList, array('prompt' => 'Pilih monitor..', 'id' => 'server')); ?>
			<?php echo $form->error($model, 'server_id', array('class' => 'error')); ?>
		</div>
	</div>

	<div class="row">
		<div class="small-4 columns">
			<?php echo $form->labelEx($model, 'notif_condition1'); ?>
			<?php echo $form->dropDownList($model, 'notif_condition1', $conditionList); ?>
			<?php echo $form->error($model, 'notif_condition1', array('class' => 'error')); ?>
		</div>
		<div class="small-8 columns">
			<?php echo $form->labelEx($model, 'notif_condition2'); ?>
			<?php echo $form->textField($model, 'notif_condition2', array('size' => 60, 'maxlength' => 500, 'placeholder' => 'Nilai tidak berpengaruh jika monitor = Uptime')); ?>
			<?php echo $form->error($model, 'notif_condition2', array('class' => 'error')); ?>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<?php echo $form->labelEx($model, 'pesan_subject'); ?>
			<?php echo $form->textField($model, 'pesan_subject', array('size' => 45, 'maxlength' => 45)); ?>
			<?php echo $form->error($model, 'pesan_subject', array('class' => 'error')); ?>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<?php echo $form->labelEx($model, 'pesan'); ?>
			<?php echo $form->textArea($model, 'pesan'); ?>
			<?php echo $form->error($model, 'pesan', array('class' => 'error')); ?>
		</div>
	</div>

	<div class="row">
		<div class="small-12 medium-6 columns">
			<?php echo $form->labelEx($model, 'aksi_id'); ?>
			<?php echo $form->dropDownList($model, 'aksi_id', $aksiList); ?>
			<?php echo $form->error($model, 'aksi_id', array('class' => 'error')); ?>
		</div>
		<div class="small-12 medium-6 columns">
			<?php echo $form->labelEx($model, 'interval'); ?>
			<?php echo $form->textField($model, 'interval', array('size' => 10, 'maxlength' => 10)); ?>
			<?php echo $form->error($model, 'interval', array('class' => 'error')); ?>
		</div>
	</div>
	<div class="row">
		<div class="small-12 columns">
			<?php echo $form->labelEx($model, 'status'); ?>
			<?php
			echo $form->radioButtonList($model, 'status', $model->getStatusList(), array(
				 'labelOptions' => array('style' => 'display:inline', 'padding-top' => '20px'),
				 'separator' => '  ',));
			?>
			<?php echo $form->error($model, 'status', array('class' => 'error')); ?>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan', array('class' => 'tiny bigfont button')); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>

</div>