<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017/1/7
 * Time: 16:04
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\LoginForm;

class CommonController extends Controller
{
    //后台只有管理员能访问
    public function beforeAction($action) {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) {
            return true;
        }
        $except = ['login', 'error'];
        $action = $action->id;
        if (in_array($action, $except)) {
            return true;
        } elseif (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
        } else {
            throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限');
        }
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    protected function ajaxSuccess($data) {
        $msg = (is_array($data)) ? '成功' : $data;
        $this->ajaxReturn(1, $msg, $data);
    }

    protected function ajaxError($data) {
        $this->ajaxReturn(0, $data, $data);
    }

    protected function ajaxReturn($status, $info, $data) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($info && is_array($info)) {
            $info = array_pop($info);
            $info = (is_array($info)) ? $info[0] : $info;
        }
        $result = ['status' => $status, 'info' => $info, 'data' => $data];
        $result = json_encode($result);
        echo $result;
    }

    protected function ajaxSuccess2($data) {
        $msg = (is_array($data)) ? '成功' : $data;
        return $this->ajaxReturn2(1, $msg, $data);
    }

    protected function ajaxError2($data) {
        return $this->ajaxReturn2(0, $data, $data);
    }

    protected function ajaxReturn2($status, $info, $data) {
        if ($info && is_array($info)) {
            $info = array_pop($info);
            $info = (is_array($info)) ? $info[0] : $info;
        }
        $result = ['status' => $status, 'info' => $info, 'data' => $data];
        return $this->asJson($result);
    }
}