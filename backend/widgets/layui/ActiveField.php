<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-10
 * Time: 15:05
 */

namespace backend\widgets\layui;


class ActiveField extends \yii\widgets\ActiveField
{
    public $options = ['class' => 'layui-inline'];
    public $inputOptions = ['class' => 'layui-input'];
    public $labelOptions = ['class' => 'layui-form-label'];
    public $template = "{label}\n<div class=\"layui-input-block\">{input}\n{hint}\n{error}</div>";

    public $inline = false;

    public function begin()
    {
        return $this->inline? parent::begin():'';
    }

    public function end()
    {
        return $this->inline? parent::end():'';
    }

    public function inline($value = true)
    {
        $this->inline = (bool) $value;
        $this->template = "{label}\n<div class=\"layui-input-inline\">{input}\n{hint}\n{error}</div>";
        return $this;
    }

    public function textarea($options = [])
    {
        $options=array_merge(['class'=>'layui-textarea',$options]);
        return parent::textarea($options);
    }

    public function checkbox($options = [], $enclosedByLabel = false)
    {
        $options=array_merge($options,['uncheck'=>null]);
        return parent::checkbox($options, $enclosedByLabel);
    }

    public function switchCheck($options=[],$enclosedByLabel=false){
        $options=array_merge($options,['lay-skin'=>'switch']);
        return $this->checkbox($options,$enclosedByLabel);
    }
}