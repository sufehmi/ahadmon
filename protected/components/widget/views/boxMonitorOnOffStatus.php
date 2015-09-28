<!--<div class="medium-6 large-4 columns left">-->
<div class="item-m">
   <div class="block" id="mon_<?php echo $monitorId; ?>">
      <div class="top-bar block-header">
         <ul class="title-area">
            <li class="name"><h1><i class="fa fa-toggle-off"></i> <?php echo $title; ?></h1></li>
         </ul>
      </div>
      <div class="block-content">
         <div class="row">
            <div class="small-12 columns">
               <table class="tabel-index">
                  <thead>
                     <tr>
                        <th>Server</th>
                        <!--<th>Address</th>-->
                        <th>Value</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     foreach ($servers as $server):
                        ?>
                        <tr>
                           <td><?php echo $server->server->nama; ?></td>
                           <!--<td><?php //echo $server->server->address;  ?></td>-->
                           <td>
                              <span class="barchart"><?php echo(ServerMonitor::model()->ambilDataTerakhir($server->server_id, $monitorId, 20)); ?></span>
                              <span class="right">
                                 <?php
                                 //echo $tipeOutput;
                                 $true = ServerMonitor::model()->ambilDataTerakhir($server->server_id, $monitorId, 1);
                                 //var_dump($hasil);

                                 echo $true ? '<span class="success label"><i class="fa fa-fw fa-ellipsis-v"></i></span>' : '<span class="alert label"><i class="fa fa-fw fa-circle-o"></i></span>'
                                 ?>
                              </span>
                           </td>
                        </tr>
                        <?php
                     endforeach;
                     ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>