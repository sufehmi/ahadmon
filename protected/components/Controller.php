<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $ipFilters = array('127.0.0.1', '::1');

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
//            array('allow',
//                'actions' => array('*'),
//                'ips' => array('127.0.0.1')
//            ),
            array('deny', // deny guest
                'users' => array('guest'),
//                'actions' => array('*'),
//                'ips' => array('*')
            ),
        );
    }

    /**
     * Cek Akses User dengan CDbAuthManager
     * @param type $action
     * @return boolean
     * @throws CHttpException
     */
    protected function beforeAction($action) {
        if ($this->allowIp(CHttpRequest::getUserHostAddress())) {
            $superUser = Yii::app()->authManager->getAuthAssignment(Yii::app()->params['superuser'], Yii::app()->user->id) === null ? FALSE : TRUE;
            if ($superUser) {
                return true;
            }
            else {
                if (Yii::app()->user->checkAccess(Yii::app()->controller->id . '.' . Yii::app()->controller->action->id)) {
                    return true;
                }
                else {
                    throw new CHttpException(403, 'Akses ditolak - Anda tidak memiliki izin untuk mengakses halaman ini!');
                }
            }
        }
        else {
            throw new CHttpException(403, 'Akses ditolak - Anda tidak memiliki izin untuk mengakses halaman ini!');
        }
    }

    /**
     * Return data to browser as JSON and end application.
     * @param array $data
     */
    protected function renderJSON($data) {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    /**
     * Checks to see if the user IP is allowed by {@link ipFilters}.
     * @param string $ip the user IP
     * @return boolean whether the user IP is allowed by {@link ipFilters}.
     */
    protected function allowIp($ip) {
        if (empty($this->ipFilters))
            return true;

        $dbIpFilters = AllowedIp::model()->findAll(array('select' => 'ip_address'));
        foreach ($dbIpFilters as $dbIpFilter) {
            $this->ipFilters[] = $dbIpFilter->ip_address;
        }

        foreach ($this->ipFilters as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos)))
                return true;
        }
        return false;
    }

}
