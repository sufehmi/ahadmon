<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/vendor/jquery.poshytip.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/vendor/jquery-editable-poshytip.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery-editable.css');

$this->widget('BGridView', array(
    'id' => 'server-list-grid',
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => array(
        array(
            'class' => 'BDataColumn',
            'name' => 'namaServer',
            'header' => 'Server <span class="ak">E</span>nabled',
            'accesskey' => 'e',
            'type' => 'raw',
            'value' => function($data) {
                return '<a href="' . Yii::app()->controller->createUrl('/server/ubah', array('id' => $data->server_id)) . '">' . $data->server->nama . '</a>';
            }
                ),
                array(
                    'name' => 'interval',
                    'headerHtmlOptions' => array('class' => 'rata-kanan'),
                    'htmlOptions' => array('class' => 'rata-kanan'),
                    'value' => function($data) {
                return '<a href="#" class="editable-value" data-type="text" data-pk="{server_id:' . $data->server_id . ',monitor_id: ' . $data->monitor_id . '}" data-url="' . Yii::app()->controller->createUrl('updateinterval') . '">' .
                        $data->interval . '</a>';
            },
                    'type' => 'raw',
                ),
                //'connection_timeout',
                array(
                    'name' => 'connection_timeout',
                    'headerHtmlOptions' => array('class' => 'rata-kanan'),
                    'htmlOptions' => array('class' => 'rata-kanan'),
                    'value' => function($data) {
                return '<a href="#" class="editable-value" data-type="text" data-pk="{server_id:' . $data->server_id . ',monitor_id: ' . $data->monitor_id . '}" data-url="' . Yii::app()->controller->createUrl('updateconnectiontimedout') . '">' .
                        $data->connection_timeout . '</a>';
            },
                    'type' => 'raw',
                ),
                array(
                    'class' => 'BButtonColumn',
                    'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delsr", array("server_id"=>$data->server_id,"monitor_id"=>$data->monitor_id))',
                    'deleteConfirmation' => false,
                    'deleteButtonLabel' => '<i class="fa fa-chevron-right"></i>',
                    'afterDelete' => 'function(link,success,data){ if(success) $.fn.yiiGridView.update(\'server-not-list-grid\'); }',
                ),
            ),
        ));
        ?>

<script>
    $(".editable-value").editable({
        success: function (response, newValue) {
            var respon = JSON && JSON.parse(response) || $.parseJSON(response);
            if (respon.sukses) {
                $.fn.yiiGridView.update("monitor-list-grid");
            }
        }
    });

    $(document).ajaxComplete(function () {
        $(".editable-value").editable({
            success: function (response, newValue) {
                var respon = JSON && JSON.parse(response) || $.parseJSON(response);
                if (respon.sukses) {
                    $.fn.yiiGridView.update("monitor-list-grid");
                }
            }
        });
    });
</script>