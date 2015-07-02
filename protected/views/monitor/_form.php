<?php
/* @var $this MonitorController */
/* @var $model Monitor */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'monitor-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data')
    ));
    ?>

    <?php echo $form->errorSummary(array($model, $monitor), 'Error: Perbaiki input', null, array('class' => 'panel')); ?>

    <div class="row">
        <div class="small-12 columns">
            <!--<label for="Monitor_nama_file">Upload Monitor:</label>-->
            <?php echo $form->fileField($model, 'nama_file', array('size' => 60, 'maxlength' => 1000)); ?>
            <?php echo $form->error($model, 'nama_file', array('class' => 'error')); ?>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <?php echo CHtml::submitButton('Upload', array('class' => 'tiny bigfont button')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>