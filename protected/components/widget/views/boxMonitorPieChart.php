<div class="medium-6 large-4 columns left">
    <div class="block">
        <div class="top-bar block-header">
            <ul class="title-area">
                <li class="name"><h1><?php echo $title; ?></h1></li>
            </ul>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="small-12 columns">
                    <table class="tabel-index">
                        <thead>
                            <tr>
                                <th>Server</th>
                                <th>Address</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($servers as $server):
                                ?>
                                <tr>
                                    <td><?php echo $server->server->nama; ?></td>
                                    <td><?php echo $server->server->address; ?></td>
                                    <td>
                                        <span class="linechart"><?php echo(ServerMonitor::model()->ambilDataTerakhir($server->server_id, $monitorId, 20)); ?></span>
                                        <span class="right">
                                            <?php
                                            $hasil = ServerMonitor::model()->ambilDataTerakhir($server->server_id, $monitorId, 1);
                                            echo(is_numeric($hasil) ? number_format($hasil, 0, ',', '.') : $hasil);
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