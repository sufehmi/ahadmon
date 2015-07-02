<?php
/* @var $this AppController */

$this->pageTitle = Yii::app()->name;
?>

<div class="row">
    <div class="small-12 columns">
        <div class="block">
            <div class="top-bar block-header">
                <ul class="title-area">
                    <li class="name"><h1><?php echo $this->pageTitle; ?></h1></li>
                </ul>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="small-12 columns">
                        <?php
                        if (Yii::app()->user->isGuest) :
                            ?>
                            <p>
                                Silahkan login untuk mengakses aplikasi
                            </p>
                            <?php
                        else :
                            ?>
                            <span class="secondary label"><h4>Login Details</h4></span>
                            <p>
                            <div style="margin-bottom: 1px"><span class="secondary label">Login</span><span class="success label"><?php echo Yii::app()->user->name; ?></span> </div>
                            <div style="margin-bottom: 1px"><span class="secondary label">Nama Lengkap</span><span class="primary label"><?php echo Yii::app()->user->namaLengkap; ?></span> </div>
                            <span class="secondary label">Hak Akses</span>
                            <?php
                            foreach ($roles as $role) :
                                ?>
                                <span class="alert label">
                                    <?php
                                    echo $role['itemname'];
                                    ?>
                                </span>
                                <?php
                            endforeach;
                            ?>
                            </p>
                        <?php
                        //echo $_SERVER['REMOTE_ADDR'];
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>