<?php
/* @var $this SetupaplikasiController */
/* @var $model WaktuServer */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery.datetimepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.datetimepicker.js', CClientScript::POS_HEAD);
?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'waktu-form',
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
            <?php echo $form->labelEx($model, 'dari'); ?>
            <?php echo $form->textField($model, 'dari', array('size' => 60, 'maxlength' => 255, 'class' => 'waktu')); ?>
            <?php echo $form->error($model, 'dari', array('class' => 'error')); ?>
        </div>

        <div class="medium-6 columns">
            <?php echo $form->labelEx($model, 'sampai'); ?>
            <?php echo $form->textField($model, 'sampai', array('size' => 60, 'maxlength' => 255, 'class' => 'waktu')); ?>
            <?php echo $form->error($model, 'sampai', array('class' => 'error')); ?>
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
    $(function () {
        $('.waktu').datetimepicker({
            datepicker: false,
            //timepicker: false,
            format: 'H:i',
            mask: true,
            //step: 15
        });
    });

    // jQuery plugin to prevent double submission of forms
    // http://stackoverflow.com/questions/2830542/prevent-double-submission-of-forms-in-jquery
    jQuery.fn.preventDoubleSubmission = function () {
        $(this).on('submit', function (e) {
            var $form = $(this);

            if ($form.data('submitted') === true) {
                // Previously submitted - don't submit again
                e.preventDefault();
            } else {
                // Mark it so that the next submit can be ignored
                $form.data('submitted', true);
            }
        });

        // Keep chainability
        return this;
    };

    $("#waktu-form").submit(function () {
        $(this).preventDoubleSubmission();
        var dataKirim = $(this).serialize();
        //console.log(dataKirim);

        $.ajax({
            url: '<?php echo $this->createUrl('tambahwaktuaplikasi'); ?>',
            data: dataKirim,
            type: "POST",
            success: function (data) {
                if (data.sukses) {
                    console.log('Simpan Waktu Aplikasi Berhasil !');
                     $.fn.yiiGridView.update('waktu-aplikasi-grid');
                }
            }
        });
        return false;
        $(this).preventDoubleSubmission();
    });

</script>