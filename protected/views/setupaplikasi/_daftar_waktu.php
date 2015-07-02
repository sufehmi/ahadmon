<?php

$this->widget('BGridView', array(
    'id' => 'waktu-aplikasi-grid',
    'dataProvider' => $model->search(),
    'summaryText' => false,
    //'filter' => $model,
    'columns' => array(
        'dari',
        'sampai',
        array(
            'class' => 'BButtonColumn',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("hapuswaktuaplikasi", array("id"=>$data->primaryKey))'
        ),
    ),
));

