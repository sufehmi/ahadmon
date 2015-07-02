<?php
/* @var $this NotifikasiaksiController */
/* @var $model NotifikasiAksi */

$this->breadcrumbs = array(
	 'Notifikasi Aksis' => array('index'),
	 'Manage',
);

$this->menu = array(
	 array('label' => 'List NotifikasiAksi', 'url' => array('index')),
	 array('label' => 'Create NotifikasiAksi', 'url' => array('create')),
);
?>

<div class="row">
	<div class="small-12 columns">
		<div class="block">
			<div class="top-bar block-header">
				<ul class="title-area">
					<li class="name"><h1>Notifikasi Aksi</h1></li>
				</ul>
				<section class="top-bar-section">
					<ul class="right">
						<li class="divider"></li>
						<li class="has-form hide-for-small-only">
							<a class="button" accesskey="t" href="<?php echo $this->createUrl('tambah'); ?>"><i class="fa fa-plus"></i> <span class="ak">T</span>ambah</a>
						</li>
						<li class="has-form show-for-small-only">
							<a class="button"  accesskey="t" href="<?php echo $this->createUrl('tambah'); ?>"><i class="fa fa-plus"></i></a>
						</li>
					</ul>
				</section>
			</div>
			<div class="block-content">
				<?php
				$this->widget('BGridView', array(
					 'id' => 'notifikasi-aksi-grid',
					 'dataProvider' => $model->search(),
					 'filter' => $model,
					 'columns' => array(
						  // 'id',
						  array(
								'class' => 'BDataColumn',
								'name' => 'nama',
								'header' => '<span class="ak">N</span>ama',
								'accesskey' => 'n',
								'type' => 'raw',
								'value' => array($this, 'renderLinkUbah')
						  ),
						  array(
								'name' => 'tipe',
								'filter' => $this->getTipeList(),
								'value' => '$data->namaTipe'
						  ),
						  'kepada',
						  'dari',
						  /*
							 'created_at',
							 'updated_at',
							 'updated_by',
							*/
						  array(
								'class' => 'BButtonColumn',
						  ),
					 ),
				));
				?>

			</div>
		</div>
	</div>
</div>