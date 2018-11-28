<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-01
 * Time: 15:24
 */

namespace backend\controllers;

use Yii;
use yii\base\InvalidValueException;
use common\rbac\EmptyRule;

class RuleController extends CommonController
{
    public function actionIndex(){
        $auth=Yii::$app->authManager;
        return $this->render('index',[
            'rules'=>$auth->getRules(),
        ]);
    }

    public function actionCreate(){
        $model=new EmptyRule();
        if(Yii::$app->request->isPost){
            $class=Yii::$app->request->post('classname');
            if(empty($post))
                throw new InvalidValueException('非法数据');
            $auth=Yii::$app->authManager;
            $rule=new $class;
            $auth->add($rule);
            $this->ajaxSuccess('1');
        }else{
            return $this->renderPartial('_form',[
                'model'=>$model,
            ]);
        }
    }
}