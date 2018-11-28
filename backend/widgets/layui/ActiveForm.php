<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-10
 * Time: 15:03
 */

namespace backend\widgets\layui;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public $options=['class'=>'layui-form'];
    public $fieldClass='backend\widgets\layui\ActiveField';
    public $enableClientScript=false;

    /**
     * @inheritdoc
     * @return ActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }
}