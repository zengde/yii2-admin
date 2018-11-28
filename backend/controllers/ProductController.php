<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-06
 * Time: 16:45
 */

namespace backend\controllers;

use backend\models\searchs\ProductDtSearch;
use backend\models\searchs\ProductSearch;
use backend\models\Category;
use backend\models\Product;
use Yii;
use yii\web\NotFoundHttpException;

class ProductController extends CommonController
{
    public function actionIndex(){
        $searchModel=new ProductSearch();
        $dataProvider=$searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'cats'=>Category::cache_category_tree()
        ]);
    }

    public function actionRecycle(){
        $searchModel=new ProductSearch();
        $dataProvider=$searchModel->search(array_merge(Yii::$app->request->queryParams,['status'=>0]));
        return $this->render('recycle',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
        ]);
    }

    public function actionDelete($id){
        $model=$this->findModel($id);
        $model->status=0;
        $model->save();
        $this->ajaxSuccess('1');
    }

    public function actionFdelete($id){
        $this->findModel($id)->delete();
        //TODO 删除相关数据
        $this->ajaxSuccess('1');
    }

    public function actionResume($id){
        $model=$this->findModel($id);
        $model->status=1;
        $model->save();
        $this->ajaxSuccess('1');
    }

    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('该产品不存在！');
        }
    }

    public function actionBatch(){
        return $this->render('batch',[
            'cats'=>Category::cache_category_tree()
        ]);
    }

    public function actionBatchList(){
        $searchModel=new ProductDtSearch();
        $res=$searchModel->search(Yii::$app->request->post());
        return $this->asJson($res);
    }

    public function actionBatchUpdate(){
        $action=Yii::$app->request->post('action','');
        $post=Yii::$app->request->post('data',[]);
        foreach ($post as $id=>$data){
            $model=$this->findModel($id);
            if($action=='remove'){
                $model->status=0;
            }elseif($action=='edit'){
                $model->load($data,'');
            }
            $model->save();
        }
        return $this->asJson(['data'=>[$model]]);
    }
}