<?php

class SetupaplikasiController extends Controller {

    public function actionIndex() {
        $waktu = new WaktuAplikasi;
        $daftarWaktu = new WaktuAplikasi('search');
        $daftarWaktu->unsetAttributes();

        $ipAddress = new AllowedIp;
        $daftarIp = new AllowedIp('search');
        $daftarIp->unsetAttributes();

        $this->render('index', array(
            'waktu' => $waktu,
            'daftarWaktu' => $daftarWaktu,
            'ipAddress' => $ipAddress,
            'daftarIp' => $daftarIp
        ));
    }

    public function actionTambahWaktuAplikasi() {
        $return = array(
            'sukses' => false
        );
        if (isset($_POST['WaktuAplikasi'])) {
            $waktuAplikasi = new WaktuAplikasi;
            $waktuAplikasi->attributes = $_POST['WaktuAplikasi'];
            if ($waktuAplikasi->save()) {
                $return = array(
                    'sukses' => true
                );
            }
        }
        $this->renderJSON($return);
    }

    public function actionHapusWaktuAplikasi($id) {
        WaktuAplikasi::model()->findByPk($id)->delete();
    }

    public function actionTambahIp() {
        $return = array(
            'sukses' => false
        );
        if (isset($_POST['AllowedIp'])) {
            $allowedIp = new AllowedIp;
            $allowedIp->attributes = $_POST['AllowedIp'];
            if ($allowedIp->save()) {
                $return = array(
                    'sukses' => true
                );
            }
        }
        $this->renderJSON($return);
    }

    public function actionHapusIp($id) {
        AllowedIp::model()->findByPk($id)->delete();
    }
}
