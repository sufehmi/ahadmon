<?php
/* @var $this ItemController */

$this->breadcrumbs = array(
    'item',
);
?>

<div class="row">
    <div class="small-12 columns">
        <div class="block">
            <div class="top-bar block-header">
                <ul class="title-area">
                    <li class="name"><h1>Auth Item</h1></li>
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
                            'id' => 'auth-item-grid',
                            'dataProvider' => $model->search(),
                            'filter' => $model,
                            'columns' => array(
                                array(
                                    'class' => 'BDataColumn',
                                    'name' => 'name',
                                    'header' => '<span class="ak">N</span>ama',
                                    'accesskey' => 'n',
                                    'type' => 'raw',
                                    'value' =>
                                    function($data) {
                                        return '<a href="' . Yii::app()->controller->createUrl('ubah', array('id' => $data->name)) . '">' . $data->name . '</a>';
                                    }
                                        ),
                                        array(
                                            'name' => 'type',
                                            'value' => '$data->authTypeName',
                                            'filter' => array('0' => 'Operation', '1' => 'Task', '2' => 'Role')
                                        ),
                                        'description',
                                        'bizrule',
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
