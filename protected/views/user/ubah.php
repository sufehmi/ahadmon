<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'List User', 'url' => array('index')),
    array('label' => 'Create User', 'url' => array('create')),
    array('label' => 'View User', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage User', 'url' => array('admin')),
);
?>
<div class="row">
    <div class="small-12 columns">
        <div class="block">
            <div class="top-bar block-header">
                <ul class="title-area">
                    <li class="name"><h1>User: <?php echo $model->nama; ?></h1></li>
                </ul>
                <section class="top-bar-section">
                    <ul class="right">
                        <li class="divider"></li>
                        <li class="has-form hide-for-small-only">
                            <ul class="button-group">
                                <li><a href="<?php echo $this->createUrl('tambah'); ?>" class="button" accesskey="t"><i class="fa fa-plus"></i> <span class="ak">T</span>ambah</a></li>
                                <li><a href="<?php echo $this->createUrl('index'); ?>" class="button" accesskey="i"><i class="fa fa-bars"></i> <span class="ak">I</span>ndex</a></li>
                            </ul>
                        </li>
                        <li class="has-form show-for-small-only">
                            <ul class="button-group">
                                <li><a href="<?php echo $this->createUrl('tambah'); ?>" class="button" accesskey="t"><i class="fa fa-plus"></i></a></li>
                                <li><a href="<?php echo $this->createUrl('index'); ?>" class="button" accesskey="i"><i class="fa fa-bars"></i></a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="large-6 columns">
                        <div class="panel">
                            <?php $this->renderPartial('_form', array('model' => $model)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>