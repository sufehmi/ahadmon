<?php
$this->widget('BGridView', array(
	 'id' => 'auth-assigned-grid',
	 'dataProvider' => $model->search(),
//	 'filter' => $model,
	 'columns' => array(
		  'itemname',
		  array(
				'header' => '',
				'value' => function($data) {
		 return '<span class="label">' . $data->authTypeName . '</span>';
	 },
				'type' => 'raw'
		  ),
		  array(
				'class' => 'CButtonColumn',
				'headerHtmlOptions' => array('style' => 'width:50px'),
				'htmlOptions' => array('style' => 'text-align:center'),
				'template' => '{delete}',
				//'updateButtonUrl' => 'Yii::app()->createUrl(\'' . $this->id . '/ubah\', array(\'id\'=>$data->child0->name))',
				'updateButtonImageUrl' => false,
				'updateButtonLabel' => '<i class="fa fa-edit"></i>',
				'updateButtonOptions' => array('title' => 'Ubah'),
				'deleteButtonUrl' => 'Yii::app()->createUrl(\'' . $this->id . '/revoke\', array(\'userid\'=>\'' . $user->id . '\',\'item\'=>$data->itemname))',
				'deleteButtonImageUrl' => false,
				'deleteButtonLabel' => '<i class="fa fa-eject"></i>',
				'deleteButtonOptions' => array('title' => 'Revoke'),
				'afterDelete' => 'function(link,success,data){ if(success) updateItemOpt(); }',
		  ),
	 ),
));

//eof