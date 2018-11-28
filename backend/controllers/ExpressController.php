<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-08
 * Time: 18:15
 */

namespace backend\controllers;

use backend\models\searchs\ExpressSearch;
use Yii;
use backend\models\ExpressCompany;
use yii\web\NotFoundHttpException;

class ExpressController extends CommonController
{
    public function actionIndex(){
        $searchModel=new ExpressSearch();
        $dataProvider=$searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionCreate(){
        $model=new ExpressCompany();
        return $this->update($model);
    }

    public function actionUpdate($id){
        $model=$this->findModel($id);
        return $this->update($model);
    }

    public function actionDelete($id){
        $model=$this->findModel($id);
        $model->delete();
        //TODO 删除对应物流报价
        $this->ajaxSuccess('1');
    }
    /**
     * @param $model \yii\db\ActiveRecord
     * @return string
     */
    protected function update($model){
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post(),'');
            if($model->save()){
                $this->ajaxSuccess('1');
            }else{
                $this->ajaxError($model->getFirstErrors());
            }
        }else{
            return $this->renderPartial('_form',[
                'model'=>$model
            ]);
        }
    }

    protected function findModel($id){
        if(($model=ExpressCompany::findOne($id))!==null){
            return $model;
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}