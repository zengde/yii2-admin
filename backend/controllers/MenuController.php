<?php

namespace backend\controllers;

use backend\models\Route;
use Yii;
use backend\models\Menu;
use yii\web\NotFoundHttpException;
use backend\models\AuthItem;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends CommonController
{
    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $menu = Menu::getLeftMenuList();

        return $this->render('index', [
            'menu' => $menu
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id='')
    {
        $model=new Menu();
        if($id)
            $model->parentid=$id;
        return $this->update($model);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->update($model);
    }

    /**
     * @param $model \backend\models\Menu
     * @return string
     */
    protected function update($model){
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post(),'');
            if($model->save()){
                Menu::invalidate();
                $this->ajaxSuccess('1');
            }else{
                $this->ajaxError($model->getFirstErrors());
            }
        }else{
            $routes=(new Route())->getAdminRoutes();
            return $this->renderPartial('_form', [
                'model' => $model,
                'routes'=>$routes,
            ]);
        }
    }
    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
