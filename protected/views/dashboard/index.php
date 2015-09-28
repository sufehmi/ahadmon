<?php
/* @var $this DashboardController */

$this->breadcrumbs = array(
    'Dashboard',
);


Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/vendor/jquery.sparkline.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/vendor/jquery-ui-sortable.min.js');
?>

<!--<div class="row">-->
<div class="masonry" id="item-masonry">
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
<!--</div>-->
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

   $('.barchart').sparkline('html', {
      type: 'bar',
      barColor: '#4da74d',
      zeroColor: '#cb4b4b',
      disableTooltips: true,
      chartRangeMin: 0,
      chartRangeMax: 1
   });
//   $('.barchart').sparkline('html', {
//      type: 'tristate',
//      posBarColor: '#4da74d',
//      zeroBarColor: '#cb4b4b',
//      disableTooltips: true
//   });

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
   $(".item-m").sortable({
      connectWith: ".item-m",
      handle: ".block-header",
      stop: function (event, ui) {
         var data = "";

         $(".item-m").each(function () {
            data += ($(this).sortable("serialize"));
            data += '&';
         });
         console.log(data);
      }
   });

</script>