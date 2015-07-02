<?php
/* @var $this DashboardController */

$this->breadcrumbs = array(
    'Dashboard',
);


Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/vendor/jquery.sparkline.js');
?>

<div class="row">
    <?php
    $this->renderPartial('_uptime_status', array(
        'servers' => $servers,
        'dataUptime' => $dataUptime,
    ))
    ?>
    <?php
    foreach ($monitorAktif as $monitor) {

        $this->widget('MonitorWidget', array(
            'title' => $monitor->monitor->nama,
            'monitorId' => $monitor->monitor_id
        ));
    }
    ?>
</div>
<script>
    $('.linechart').sparkline('html', {
        type: 'line',
        lineColor: '#7A92A3',
        minSpotColor: '#cb4b4b',
        maxSpotColor: '#0b62a4',
        //spotColor: '#cb4b4b',
        fillColor: '#afd8f8',
        spotRadius: 2,
        height: '27px',
    });

    $('.discrete').sparkline('html', {
        type: 'discrete',
    });

    $(function () {
        window.setTimeout(reload, 60000);
    });

    function reload() {
        console.log('reload');
        location.reload();
    }
</script>
<?php
/*
<div style="background-color: #0b62a4; width:50px; height:50px;float:left;">Biru</div>
<div style="background-color: #7A92A3; width:50px; height:50px;float:left;">Biru Muda</div>
<div style="background-color: #4da74d; width:50px; height:50px;float:left;">Hijau</div>
<div style="background-color: #afd8f8; width:50px; height:50px;float:left;">Toska</div>
<div style="background-color: #edc240; width:50px; height:50px;float:left;">Orange</div>
<div style="background-color: #cb4b4b; width:50px; height:50px;float:left;">Merah</div>
<div style="background-color: #9440ed; width:50px; height:50px;float:left;">Violet</div>
 *
 */