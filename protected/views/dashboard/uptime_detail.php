<?php
/* @var $this DashboardController */
?>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/jquery.datetimepicker.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.datetimepicker.js', CClientScript::POS_HEAD);
?>

<div class="small-12 columns">
    <div class="block">
        <div class="top-bar block-header">
            <ul class="title-area">
                <li class="name"><h1>Server: <?php echo $server->nama; ?></h1></li>
            </ul>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="medium-6 large-4 columns">
                    <div class="row">
                        <div class="panel">
                            <h5><small>Show</small> Summary</h5>
                            <form>
                                <div class="row">
                                    <div class="small-6 columns">
                                        <label for="Filter_dari">Dari:</label>
                                        <input type="text" id="Filter_dari" name="Filter[dari]" class="tanggalwaktu" value="<?php echo date('Y-m-d'); ?> 00:00"/>
                                    </div>
                                    <div class="small-6 columns end">
                                        <label for="Filter_sampai">Sampai:</label>
                                        <input type="text" id="Filter_sampai" name="Filter[sampai]" class="tanggalwaktu" value="<?php echo date('Y-m-d'); ?> 23:59"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="small-6 columns">
                                        <!--<input type="submit" value="Submit" class="tiny bigfont button"/>-->
                                        <?php
                                        //ajaxSubmitButton(string $label, mixed $url, array $ajaxOptions=array ( ), array $htmlOptions=array ( ))
                                        echo CHtml::ajaxSubmitButton('Submit', $this->createUrl('uptimedetailsummary', array('serverId' => $server->id)), array(
                                            'success' => 'function(data){'
                                            . 'isiSummary(data);'
                                            . '}'
                                                ), array(
                                            'class' => 'tiny bigfont button',
                                            'id' => 'tombol-submit-filter'
                                        ));
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="medium-6 large-4 columns">
                    <div class="panel">
                        <h5>Summary</h5>
                        <table class="detail-view" width="100%">
                            <tbody>
                                <tr>
                                    <th>Rata-rata</th>
                                    <td id="summary-rerata"></td>
                                </tr>
                                <tr>
                                    <th>Gagal</th>
                                    <td id="summary-gagal" class="error"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $this->widget('BGridView', array(
                    'id' => 'uptime-detail-grid',
                    'dataProvider' => $model->search(),
                    //'filter' => $model,
                    'columns' => array(
                        'waktu',
                        'result',
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    function isiSummary(data) {
        $("#summary-rerata").text(data.rerata);
        $("#summary-gagal").text(data.gagal + ' (' + data.gagalPersen + '%)');
    }

    $(function () {
        // auto refresh
        setInterval(function () {
            $.fn.yiiGridView.update("uptime-detail-grid");
            $("#tombol-submit-filter").click();
        }, 30000);
    });

    $(function () {
        $('.tanggalwaktu').datetimepicker({
            format: 'Y-m-d H:i',
            mask: true,
            //step: 15
        });
    });
</script>