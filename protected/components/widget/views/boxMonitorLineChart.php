<div class="medium-6 large-4 columns left">
	<div class="block">
		<div class="top-bar block-header">
			<ul class="title-area">
				<li class="name"><h1><i class="fa fa-area-chart"></i> <?php echo $title; ?></h1></li>
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
									<td><?php echo "{$server->server->nama} <small>[{$server->server->address}]</small>"; ?>
										<div class="linechart"><?php echo(ServerMonitor::model()->ambilDataTerakhir($server->server_id, $monitorId, 50)); ?></div>
									</td>
									<td>
										<span class="right">
											<a href="<?php echo Yii::app()->createUrl('dashboard/monitordetail', ['id' => $monitorId, 'serverId' => $server->server_id]) ?>">
												<div>Last: <?php
													$hasil = ServerMonitor::model()->ambilDataTerakhir($server->server_id, $monitorId, 1);
													if ($hasil == 'null') {
														?>
														<span class="alert label">null</span>
														<?php
													} else {
														?>
														<span class="primary label"><?php echo $server->monitor->prefix; ?>
															<?php
															//echo $tipeOutput;
															//var_dump($hasil);
															if ($tipeOutput === 'numeric') :
																echo number_format($hasil * 1, 0, ',', '.');
															else:
																// if decimal
																echo number_format($hasil * 1, 2, ',', '.');
															endif;
															?>
															<?php echo $server->monitor->suffix; ?></span>
														<?php
													}
													?>
												</div>
											</a>
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