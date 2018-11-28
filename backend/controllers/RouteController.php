<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-05-26
 * Time: 11:40
 */

namespace backend\controllers;

use Yii;
use backend\models\Route;

class RouteController extends CommonController
{
    public function actionIndex(){
        $model=new Route();
        return $this->render('index',[
            'routes'=>$model->getRoutes(),
        ]);
    }

    public function actionCreate(){
        $routes = Yii::$app->request->post('route', '');
        $routes = preg_split('/\s*,\s*/', trim($routes), -1, PREG_SPLIT_NO_EMPTY);
        $model = new Route();
        $model->addNew($routes);
        return $this->ajaxSuccess2($model->getRoutes());
    }

    /**
     * Assign routes
     * @return void
     */
    public function actionAssign()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->addNew($routes);
        $this->ajaxSuccess2($model->getRoutes());
    }

    /**
     * Remove routes
     * @return void
     */
    public function actionRemove(){
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->remove($routes);
        $this->ajaxSuccess($model->getRoutes());
    }

    /**
     * Refresh cache
     * @return void
     */
    public function actionRefresh()
    {
        Route::invalidate();
        $this->ajaxSuccess((new Route)->getRoutes());
    }
}