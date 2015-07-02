<?php
/* @var $this AssignmentController */
/* @var $model AuthAssignment */
//
//$this->breadcrumbs = array(
//	 'Auth Items' => array('index'),
//	 $model->name => array('view', 'id' => $model->name),
//	 'Update',
//);
?>
<div class="row">
    <div class="small-12 columns">
        <div class="block">
            <div class="top-bar block-header">
                <ul class="title-area">
                    <li class="name"><h1>Assignment: <?php echo $user->nama; ?></h1></li>
                </ul>
                <section class="top-bar-section">
                    <ul class="right">
                        <li class="divider"></li>
                        <li class="has-form hide-for-small-only">
                            <ul class="button-group">
                                <li><a href="<?php echo $this->createUrl('index'); ?>" class="button" accesskey="i"><i class="fa fa-bars"></i> <span class="ak">I</span>ndex</a></li>
                            </ul>
                        </li>
                        <li class="has-form show-for-small-only">
                            <ul class="button-group">
                                <li><a href="<?php echo $this->createUrl('index'); ?>" class="button"accesskey="i"><i class="fa fa-bars"></i></a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="large-6 columns">
                        <?php
                        $this->renderPartial('_assignment', array(
                            'user' => $user,
                            'authItem' => $authItem
                        ));
                        ?>
                        <?php
                        $this->renderPartial('_list_assigned', array(
                            'user' => $user,
                            'model' => $model
                        ));
                        ?>
                    </div>
                    <div class="large-6 columns">
                        <?php
//						$this->renderPartial('_child', array(
//							 'model' => $child,
//							 'id' => $model->name,
//							 'authItem' => $authItem,
//						));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>