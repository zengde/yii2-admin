<?php
/**
 * 物流报价
 * User: zeng
 * Date: 2017-06-10
 * Time: 11:05
 */

namespace backend\controllers;

use backend\models\ExpressCompany;
use backend\models\ExpressQuote;
use Yii;
use backend\models\searchs\ExpressQuoteSearch;
use backend\models\Area;
use yii\web\NotFoundHttpException;

class ExpressQuoteController extends CommonController
{
    public function actionIndex(){
        $searchModel=new ExpressQuoteSearch();
        $dataProvider=$searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'trees'=>Area::cache_area_tree()
        ]);
    }

    public function actionCreate(){
        $model=new ExpressQuote();
        return $this->update($model);
    }

    public function actionUpdate($id){
        $model=$this->findModel($id);
        return $this->update($model);
    }

    public function actionDelete($id){
        $model=$this->findModel($id);
        $model->delete();
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
                'model'=>$model,
                'express'=>ExpressCompany::find()->all(),
            ]);
        }
    }

    protected function findModel($id){
        if(($model=ExpressQuote::findOne($id))!==null){
            return $model;
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}