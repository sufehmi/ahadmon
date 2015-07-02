<?php
/* @var $this AuthitemController */
/* @var $model AuthItem */

$this->breadcrumbs = array(
    'Auth Items' => array('index'),
    $model->name => array('view', 'id' => $model->name),
    'Update',
);

$this->menu = array(
    array('label' => 'List AuthItem', 'url' => array('index')),
    array('label' => 'Create AuthItem', 'url' => array('create')),
    array('label' => 'View AuthItem', 'url' => array('view', 'id' => $model->name)),
    array('label' => 'Manage AuthItem', 'url' => array('admin')),
);
?>
<div class="row">
    <div class="small-12 columns">
        <div class="block">
            <div class="top-bar block-header">
                <ul class="title-area">
                    <li class="name"><h1>Auth Item: <?php echo $model->name; ?></h1></li>
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
                    <div class="large-6 columns">
                        <div class="panel">
                            <?php
                            $this->renderPartial('_child', array(
                                'model' => $child,
                                'id' => $model->name,
                                'authItem' => $authItem,
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>