<?php

namespace backend\controllers;

use backend\models\Route;
use Yii;
use backend\models\AuthItem;
use backend\models\searchs\AuthItem as AuthItemSearch;
use yii\base\NotSupportedException;
use yii\rbac\Item;
use yii\web\NotFoundHttpException;

/**
 * ItemController implements the CRUD actions for AuthItem model.
 */
class ItemController extends CommonController
{
    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex($template='/item/index')
    {
        $searchModel = new AuthItemSearch(['type' => $this->type]);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render($template, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'labels'=>$this->labels(),
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param  string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->renderPartial('/item/view', [
            'model' => $model,
            'routes'=>$this->getItems($id)
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();
        $model->type = $this->type;
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->getRequest()->post(),'');
            if($model->addItem()){
                return $this->ajaxSuccess2('1');
            }else{
                return $this->ajaxError2('0');
            }
        }else {
            return $this->renderPartial('/item/_form', ['model' => $model]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->getRequest()->post(),'');
            if($model->updateItem()){
                return $this->ajaxSuccess2('1');
            }
        }else{
            return $this->renderPartial('/item/_form', ['model' => $model]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->romoveItem();
        return $this->redirect(['index']);
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('routes', []);
        $success=$this->findModel($id)->addChildren($items);

        $res=$this->getType()==Item::TYPE_PERMISSION? $this->getItems($id):'1';
        if($success)
            return $this->ajaxSuccess2($res);
        else
            return $this->ajaxError2('0');
    }

    /**
     * Assign or remove items
     * @param string $id
     * @return array
     */
    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('routes', []);
        $this->findModel($id)->removeChildren($items);

        $res=$this->getType()==Item::TYPE_PERMISSION? $this->getItems($id):'1';
        return $this->ajaxSuccess2($res);
    }

    /**
     * Label use in view
     * @throws NotSupportedException
     */
    public function labels()
    {
        throw new NotSupportedException(get_class($this) . ' does not support labels().');
    }

    /**
     * Type of Auth Item.
     * @return integer
     */
    public function getType()
    {

    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('编辑的角色或权限不存在！');
        }
    }

    protected function getItems($id){
        $auth=Yii::$app->authManager;

        $avaliable=$auth->getPermissions();
        $assigned=$auth->getChildren($id);
        $avaliable=array_diff_key($avaliable,$assigned);

        return [
            'avaliable' => $avaliable,
            'assigned' => $assigned
        ];
    }
}
