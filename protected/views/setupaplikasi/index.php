<?php
/* @var $this SetupaplikasiController */

$this->breadcrumbs = array(
    'Setupaplikasi',
);
?>
<div class="medium-6 large-4 columns">
    <div class="block">
        <div class="top-bar block-header">
            <ul class="title-area">
                <li class="name"><h1><i class="fa fa-toggle-on"></i> Waktu Monitoring</h1></li>
            </ul>
        </div>
        <div class="block-content">
            <div class="row">
                <?php
                $this->renderPartial('_daftar_waktu', array(
                    'model' => $daftarWaktu
                ))
                ?>
            </div>
            <div class="panel">
                <h5 id="input-waktu" class="input-toogle">Input <small>Waktu</small></h5>
                <div class="row">
                    <?php
                    $this->renderPartial('_form_waktu', array(
                        'model' => $waktu,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="medium-6 large-4 columns">
    <div class="block">
        <div class="top-bar block-header">
            <ul class="title-area">
                <li class="name"><h1><i class="fa fa-unlock-alt"></i> Allowed IP</h1></li>
            </ul>
        </div>
        <div class="block-content">
            <div class="row">
                <?php
                $this->renderPartial('_daftar_ip', array(
                    'model' => $daftarIp
                ))
                ?>
            </div>
            <div class="panel">
                <h5 id="input-ips" class="input-toogle">Input <small>IP Address (* for allow All)</small></h5>
                <div class="row">
                    <?php
                    $this->renderPartial('_form_ip', array(
                        'model' => $ipAddress,
                    ))
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.toogle-form').hide();
    });

    $("#input-waktu").click(function () {
        $("#waktu-form").slideToggle(500);
    });

    $("#input-ips").click(function () {
        $("#ips-form").slideToggle(500);
    });
</script>
