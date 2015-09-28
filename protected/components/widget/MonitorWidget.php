<?php

class MonitorWidget extends CWidget {

   public $title;
   public $monitorId;

   public function run() {
      $servers = ServerMonitor::model()->ambilServers($this->monitorId);
      $monitor = Monitor::model()->findByPk($this->monitorId);
      $tipeOutput = $monitor->outputType->nama;
      $tipeView = $monitor->viewType->nama;

      switch ($tipeView) :
         case 'linechart':
            $view = 'boxMonitorLineChart';
            break;
         case 'onoffstatus':
            $view = 'boxMonitorOnOffStatus';
            break;
         case 'text':
            $view = 'boxMonitorText';
            break;
      endswitch;

      $this->render($view, array(
          'title' => $this->title,
          'monitorId' => $this->monitorId,
          'servers' => $servers,
          'tipeOutput' => $tipeOutput,
      ));
   }

}
