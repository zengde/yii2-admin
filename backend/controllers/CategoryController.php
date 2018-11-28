<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-03
 * Time: 17:50
 */

namespace backend\controllers;

use backend\behaviors\CategoryBehavior;
use Yii;
use backend\components\Helper;
use backend\models\Category;
use yii\base\ActionEvent;
use yii\web\NotFoundHttpException;

class CategoryController extends CommonController
{
    const EVENT_AFTER_INSERT = 'afterInsert';
    const EVENT_AFTER_UPDATE = 'afterUpdate';
    const EVENT_AFTER_DELETE = 'afterDelete';

    public function actionIndex(){
        $list=Category::find()->indexBy('id')->asArray()->all();
        $list=Helper::genTree5($list);
        return $this->render('index',[
            'list'=>$list
        ]);
    }

    public function actionCreate($id=''){
        $model=new Category();
        if($id)
            $model->parentid=$id;
        return $this->update($model,'afterinsert');
    }

    public function actionUpdate($id){
        $model=$this->findModel($id);
        return $this->update($model,'afterupdate');
    }

    /**
     * @param $model \frontend\models\Category
     * @return string
     */
    protected function update($model,$afterfunc){
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post(),'');
            if($model->upload()&&$model->save(false)){
                $this->$afterfunc($model);
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

    public function actionDelete($id){
        $model=$this->findModel($id);
        $model->delete();
        $this->afterDelete($model);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function behaviors()
    {
        return [
            CategoryBehavior::className(),
        ];
    }

    protected function afterInsert($model){
        $event=new ActionEvent($this->action);
        $event->result=$model;
        $this->trigger(self::EVENT_AFTER_INSERT,$event);
    }
    protected function afterUpdate($model){
        $event=new ActionEvent($this->action);
        $event->result=$model;
        $this->trigger(self::EVENT_AFTER_UPDATE,$event);
    }
    protected function afterDelete($model){
        $event=new ActionEvent($this->action);
        $event->result=$model;
        $this->trigger(self::EVENT_AFTER_DELETE,$event);
    }
}