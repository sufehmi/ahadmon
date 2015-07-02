<?php
/* @var $this NotifikasiController */
/* @var $model Notifikasi */

$this->breadcrumbs = array(
	 'Notifikasis' => array('index'),
	 $model->id => array('view', 'id' => $model->id),
	 'Update',
);
?>
<div class="row">
	<div class="small-12 columns">
		<div class="block">
			<div class="top-bar block-header">
				<ul class="title-area">
					<li class="name"><h1>Notifikasi: <?php //echo $model->nama;  ?></h1></li>
				</ul>
				<section class="top-bar-section">
					<ul class="right">
						<li class="divider"></li>
						<li class="has-form hide-for-small-only">
							<ul class="button-group">
								<li><a accesskey="t" href="<?php echo $this->createUrl('tambah'); ?>" class="button"><i class="fa fa-plus"></i> <span class="ak">T</span>ambah</a></li>
								<li><a accesskey="i" href="<?php echo $this->createUrl('index'); ?>" class="button"><i class="fa fa-bars"></i> <span class="ak">I</span>ndex</a></a></li>
							</ul>
						</li>
						<li class="has-form show-for-small-only">
							<ul class="button-group">
								<li><a accesskey="t" href="<?php echo $this->createUrl('tambah'); ?>" class="button"><i class="fa fa-plus"></i></a></li>
								<li><a accesskey="i" href="<?php echo $this->createUrl('index'); ?>" class="button"><i class="fa fa-bars"></i></a></li>
							</ul>
						</li>
					</ul>
				</section>
			</div>
			<div class="block-content">
				<div class="row">
					<div class="large-6 columns">
						<?php
						$this->renderPartial('_form', array(
							 'model' => $model,
							 'serverList' => $serverList,
							 'conditionList' => $conditionList,
							 'monitorList' => $monitorList,
							 'aksiList' => $aksiList));
						?>					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>