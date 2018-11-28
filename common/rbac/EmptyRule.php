<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-01
 * Time: 16:16
 */

namespace common\rbac;


use yii\rbac\Item;
use yii\rbac\Rule;

class EmptyRule extends Rule
{
    public $name='';

    public static function className()
    {
        return '';
    }

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        // TODO: Implement execute() method.
    }
}