<?php

namespace backend\controllers;
use backend\models\Log;
use backend\models\Menu;
use backend\models\PasswordForm;
use yii\data\Pagination;

use Yii;

class IndexController extends CommonController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMain(){
        return $this->render('main');
    }
}

