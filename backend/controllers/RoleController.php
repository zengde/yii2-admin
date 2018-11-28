<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-01
 * Time: 14:38
 */

namespace backend\controllers;

use backend\models\AuthItemChild;
use Yii;
use yii\rbac\Item;
use backend\models\searchs\AuthItem as AuthItemSearch;

class RoleController extends ItemController
{
    /**
     * @inheritdoc
     */
    public function labels()
    {
        return[
            'type' => '角色',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_ROLE;
    }

    public function actionIndex($template = '/role/index')
    {
        $searchModel = new AuthItemSearch(['type' => $this->type]);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render($template, [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'labels'=>$this->labels(),
            'items'=>AuthItemChild::cache_item_tree()
        ]);
    }

    public function actionView($id)
    {
        $auth=Yii::$app->authManager;
        return $this->ajaxSuccess2($auth->getChildren($id));
    }
}