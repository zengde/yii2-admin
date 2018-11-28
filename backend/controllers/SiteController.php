<?php
namespace backend\controllers;

use Yii;
use backend\models\Menu;

/**
 * Site controller
 */
class SiteController extends CommonController
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLeftMenu(){
        $menu = Menu::getLeftMenuList();
        $menu[1]['spread']=true;
        $this->ajaxSuccess($menu);
    }
}
