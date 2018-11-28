<?php

namespace backend\controllers;
use backend\models\AuthItem;
use backend\models\Group;
use backend\components\MyDataProvider;
use common\models\User;
use backend\components\Tree;

use Yii;
use yii\web\NotFoundHttpException;

class UserController extends CommonController
{

    //用户列表
    public function actionList($name='')
    {
        $query=User::find()->with('item')->andFilterWhere(['like','username',$name]);
        $dataProvider=new MyDataProvider(['query'=>$query]);
        return $this->render('list',[
            'dataProvider'=>$dataProvider
        ]);
    }

    //新增用户
    public function actionCreate()
    {
        return $this->userSave(new User());
    }

    //更新用户
    public function actionUpdate($id){
        $model = $this->findModel($id);
        $model->setScenario('update');
        return $this->userSave($model);
    }
    //删除用户
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        if($model->delete()){
            $auth=Yii::$app->authManager;
            $auth->revokeAll($id);
        }
        $this->ajaxSuccess('1');
    }
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     *添加/编辑用户
     * @param \common\models\User $model
     */
    protected function userSave($model){
        $auth=Yii::$app->authManager;
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post(),'');
            $password=Yii::$app->request->post('password','');
            $assign=Yii::$app->request->post('rolename','');
            if(!empty($password)){
                $model->setPassword($password);
                $model->generateAuthKey();
            }
            if($assign=='超级管理员')
                $model->roleid=$model::ROLE_ADMIN;
            if($model->save(false)){
                //分配角色
                if($assign){
                    $role = $auth->createRole($assign); //创建角色对象
                    $auth->revokeAll($model['id']);//先删除已分配的
                    $auth->assign($role, $model['id']);//添加对应关系
                }
                $this->ajaxSuccess('1');
            }else{
                $this->ajaxError($model->getFirstErrors());
            }
        }else{
            return $this->renderPartial('_form', [
                'model' => $model,
                'roles'=>$auth->getRoles(),
                'groups'=>Group::find()->where('status=1')->all()
            ]);
        }
    }

    //分配权限
    public function actionAssign($id){
        if(Yii::$app->request->isPost){
            $items = Yii::$app->getRequest()->post('routes', []);
            $manager = Yii::$app->getAuthManager();
            $success = 0;
            foreach ($items as $name) {
                $item = $manager->getRole($name);
                $item = $item ? : $manager->getPermission($name);
                $manager->assign($item, $id);
                $success++;
            }
            $this->ajaxSuccess($this->getRoutes($id));
        }else{
            return $this->renderPartial('assign',[
                'id'=>$id,
                'items'=>$this->getRoutes($id)
            ]);
        }
    }

    //删除权限
    public function actionRevoke($id){
        $manager=Yii::$app->authManager;
        $items = Yii::$app->getRequest()->post('routes', []);
        $success = 0;
        foreach ($items as $name) {
            $item = $manager->getRole($name);
            $item = $item ? : $manager->getPermission($name);
            $manager->revoke($item, $id);
            $success++;
        }
        $this->ajaxSuccess($this->getRoutes($id));
    }

    protected function getRoutes($id){
        $manager = Yii::$app->getAuthManager();
        $avaliable = [];
        foreach (array_keys($manager->getRoles()) as $name) {
            $avaliable[$name] = 'role';
        }

        foreach (array_keys($manager->getPermissions()) as $name) {
            if (strpos($name,'/')===false) {
                $avaliable[$name] = 'permission';
            }
        }

        $assigned = [];
        foreach ($manager->getAssignments($id) as $item) {
            $assigned[$item->roleName] = $avaliable[$item->roleName];
            unset($avaliable[$item->roleName]);
        }

        return[
            'avaliable' => $avaliable,
            'assigned' => $assigned
        ];
    }
}
