<?php
/* @var $this MonitorController */
/* @var $model Monitor */

$this->breadcrumbs = array(
    'Monitors' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Monitor', 'url' => array('index')),
    array('label' => 'Create Monitor', 'url' => array('create')),
);
?>

<div class="row">
    <div class="small-12 columns">
        <div class="block">
            <div class="top-bar block-header">
                <ul class="title-area">
                    <li class="name"><h1>Monitor</h1></li>
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
                    'id' => 'monitor-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'class' => 'BDataColumn',
                            'name' => 'nama',
                            'header' => '<span class="ak">N</span>ama',
                            'accesskey' => 'n',
                            'type' => 'raw',
                            'value' => function($data) {
                                return '<a href="' . Yii::app()->controller->createUrl('ubah', array('id' => $data->id)) . '">' . $data->nama . '</a>';
                            }
                        ),
                        'perintah',
                        'deskripsi',
                        array(
                            'name' => 'outputTypeName',
                            'value' => '$data->outputType->nama'
                        ),
                        array(
                            'name' => 'viewTypeName',
                            'value' => '$data->viewType->nama'
                        ),
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