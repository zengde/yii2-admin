<?php
namespace common\rbac;

use Yii;
use yii\rbac\Rule;

/**
 * Checks if user group matches
 */
class AdminRule extends Rule
{
    public $name='adminGroup';
    
    public function execute($user, $item, $params) {
        if (!Yii::$app->user->isGuest) {
            return Yii::$app->user->identity->isAdmin;
        }
        return false;
    }

}

