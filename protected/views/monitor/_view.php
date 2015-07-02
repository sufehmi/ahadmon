<div style="margin-bottom: 1px">
    <span class="label"><?php echo $model->getAttributeLabel('nama'); ?></span><span class="secondary label"><?php echo $model->nama; ?></span>
</div>

<div style="margin-bottom: 1px">
    <span class="label"><?php echo $model->getAttributeLabel('deskripsi'); ?></span><span class="secondary label"><?php echo $model->deskripsi; ?></span>
</div>

<!--<div style="margin-bottom: 1px">
    <span class="label"><?php //echo $model->getAttributeLabel('perintah');   ?></span><span class="secondary label"><?php echo $model->perintah; ?></span>
</div>-->

<div style="margin-bottom: 1px">
    <span class="label"><?php echo $model->getAttributeLabel('outputTypeName'); ?></span><span class="secondary label"><?php echo $model->outputType->nama; ?></span>
</div>

<div  style="margin-bottom: 1px">
    <span class="label"><?php echo $model->getAttributeLabel('viewTypeName'); ?></span><span class="secondary label"><?php echo $model->viewType->nama; ?></span>
</div>

<?php
if (isset($model->prefix)):
    ?>
<div  style="margin-bottom: 1px">
    <span class="label"><?php echo $model->getAttributeLabel('prefix'); ?></span><span class="secondary label"><?php echo $model->prefix; ?></span>
</div>
    <?php
endif;
?>

<?php
if (isset($model->suffix)):
    ?>
<div  style="margin-bottom: 10px">
    <span class="label"><?php echo $model->getAttributeLabel('suffix'); ?></span><span class="secondary label"><?php echo $model->suffix; ?></span>
</div>
    <?php
endif;
