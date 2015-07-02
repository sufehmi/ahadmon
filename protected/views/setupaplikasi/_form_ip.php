<?php
/* @var $this SetupaplikasiController */
/* @var $model AllowedIp */
/* @var $form CActiveForm */
?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ips-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'toogle-form')
    ));
    ?>

    <?php echo $form->errorSummary($model, 'Error: Perbaiki input', null, array('class' => 'panel callout')); ?>

    <div class="row">
        <div class="medium-6 columns">
            <?php echo $form->labelEx($model, 'ip_address'); ?>
            <?php echo $form->textField($model, 'ip_address', array('size' => 45, 'maxlength' => 45)); ?>
            <?php echo $form->error($model, 'ip_address', array('class' => 'error')); ?>
        </div>

        <div class="medium-6 columns">
            <?php echo $form->labelEx($model, 'nama'); ?>
            <?php echo $form->textField($model, 'nama', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'nama', array('class' => 'error')); ?>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan', array('class' => 'small-12 column tiny bigfont button')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>

<script>

    $("#ips-form").submit(function () {
        $(this).preventDoubleSubmission();
        var dataKirim = $(this).serialize();
        //console.log(dataKirim);

        $.ajax({
            url: '<?php echo $this->createUrl('tambahip'); ?>',
            data: dataKirim,
            type: "POST",
            success: function (data) {
                if (data.sukses) {
                    console.log('Simpan IP Address Berhasil !');
                    $.fn.yiiGridView.update('allowed-ip-grid');
                }
            }
        });
        return false;
        $(this).preventDoubleSubmission();
    });

</script>