
<div class="row">
    <div class="small-12 columns">
        <div class="block">
            <div class="top-bar block-header">
                <ul class="title-area">
                    <li class="name"><h1>Tambah AuthItem</h1></li>
                </ul>
                <section class="top-bar-section">
                    <ul class="right">
                        <li class="divider"></li>
                        <li class="has-form hide-for-small-only">
                            <a href="<?php echo $this->createUrl('index'); ?>" class="button" accesskey="i"><i class="fa fa-bars"></i> <span class="ak">I</span>ndex</a>
                        </li>
                        <li class="has-form show-for-small-only">
                            <a class="button" href="<?php echo $this->createUrl('index'); ?>" accesskey="i"><i class="fa fa-bars"></i></a>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="large-6 columns">
                        <div class="panel">
                            <?php $this->renderPartial('_form', array('model' => $model)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>