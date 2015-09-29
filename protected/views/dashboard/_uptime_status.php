<!--<div class="large-4 columns left">-->
<div class="item-m">
   <div class="block" id="mon_0">
      <div class="top-bar block-header">
         <ul class="title-area">
            <li class="name"><h1><i class="fa fa-area-chart"></i> Uptime</h1></li>
         </ul>
      </div>
      <div class="block-content">
         <div class="row">
            <div class="small-12 columns">
               <table class="tabel-index">
                  <tbody>
                     <?php
                     foreach ($servers as $server):
                        ?>
                        <tr>
                           <td>
                              <?php echo "{$server->nama} <small>[ {$server->address} ]</small>"; ?>
                              <div class="linechart"><?php echo($dataUptime[$server->id]['data']); ?></div>
                           </td>
                           <td class="rata-kanan">
                              <a href="<?php echo $this->createUrl('viewuptimedetail', ['server_id' => $server->id]) ?>">
                                 <?php
                                 if (isset($dataUptime[$server->id]['terakhir'])):
                                    ?>
                                    <div>Status: <strong>Connected</strong></div>
                                    <div>Last: <span class="primary label"><?php echo number_format($dataUptime[$server->id]['terakhir'] * 1 / 1000, 2, ',', '.') ?> s</span></div>

      <!--                                            <span class="success label"><h6><?php //echo number_format($dataUptime[$server->id]['terakhir'] * 1 / 1000, 2, ',', '.')  ?> s</h6></span>-->
                                    <?php
                                 else :
                                    ?>
                                    <span class="alert label">Disconnected</span>
                                 <?php
                                 endif;
                                 ?>
                              </a>
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