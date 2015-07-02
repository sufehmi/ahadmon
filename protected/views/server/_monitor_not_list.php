<?php

$this->widget('BGridView', array(
    'id' => 'monitor-not-list-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => array(
        array(
            'class' => 'BButtonColumn',
            // Enable Button
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("enmon", array("id"=>$data->primaryKey,"serverId"=>' . $server->id . '))',
            'deleteButtonImageUrl' => false,
            'deleteButtonLabel' => '<i class="fa fa-chevron-left"></i>',
            'deleteButtonOptions' => array('title' => 'Enable'),
            'deleteConfirmation' => false,
            'afterDelete' => 'function(link,success,data){ if(success) $.fn.yiiGridView.update(\'monitor-list-grid\'); }',
        ),
        array(
            'class' => 'BDataColumn',
            'name' => 'nama',
            'header' => 'Monitor <span class="ak">A</span>vailable',
            'accesskey' => 'a',
            'type' => 'raw',
            'value' => function($data) {
                return '<a href="' . Yii::app()->controller->createUrl('/monitor/ubah', array('id' => $data->id)) . '">' . $data->nama . '</a>';
            }
                ),
            ),
        ));
