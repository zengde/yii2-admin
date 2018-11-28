<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-20
 * Time: 16:17
 */

namespace backend\controllers;

use backend\models\AuthItemChild;
use backend\models\Menu;
use backend\models\Route;

class CacheController extends CommonController
{
    public function cache($force=false){
        Menu::getLeftMenuList();
        AuthItemChild::cache_item_tree();
    }

    public function clear(){
        Menu::invalidate();
        AuthItemChild::invalidate();
        Route::invalidate();
    }
}