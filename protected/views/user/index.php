<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List User', 'url' => array('index')),
    array('label' => 'Create User', 'url' => array('create')),
);
?>

<div class="row">
    <div class="small-12 columns">
        <div class="block">
            <div class="top-bar block-header">
                <ul class="title-area">
                    <li class="name"><h1>User</h1></li>
                </ul>
                <section class="top-bar-section">
                    <ul class="right">
                        <li class="divider"></li>
                        <li class="has-form hide-for-small-only">
                            <a href="<?php echo $this->createUrl('tambah'); ?>" class="button" accesskey="t"><i class="fa fa-plus"></i> <span class="ak">T</span>ambah</a>
                        <li class="has-form show-for-small-only">
                            <a class="button" href="<?php echo $this->createUrl('tambah'); ?>" accesskey="t"><i class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="small-12 columns">
                         <?php
                $this->widget('BGridView', array(
                    'id' => 'user-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'columns' => array(
                        array(
                            'class' => 'BDataColumn',
                            'name' => 'nama',
                            'header' => '<span class="ak">N</span>ama',
                            'accesskey' => 'n',
                            'value' => function($data) {
                                return '<a href="' . Yii::app()->controller->createUrl('ubah', array('id' => $data->id)) . '">' . $data->nama . '</a>';
                            },
                                    'type' => 'raw'
                                ),
                                'nama_lengkap',
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
    </div>
</div>
