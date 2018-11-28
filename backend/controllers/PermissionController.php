<?php

namespace backend\controllers;

use yii\rbac\Item;

/**
 * PermissionController implements the CRUD actions for AuthItemChild model.
 */
class PermissionController extends ItemController
{
    /**
     * @inheritdoc
     */
    public function labels()
    {
        return[
            'type' => '权限',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Item::TYPE_PERMISSION;
    }
}
