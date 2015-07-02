<?php

$this->widget('BGridView', array(
    'id' => 'allowed-ip-grid',
    'dataProvider' => $model->search(),
    'summaryText' => false,
    //'filter' => $model,
    'columns' => array(
        'ip_address',
        'nama',
        array(
            'class' => 'BButtonColumn',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("hapusip", array("id"=>$data->primaryKey))'
        ),
    ),
));

