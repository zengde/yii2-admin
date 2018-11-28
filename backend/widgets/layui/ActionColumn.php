<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-10
 * Time: 16:02
 */

namespace backend\widgets\layui;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $header = '操作';

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', '',[
            'class'=>'layui-btn layui-btn-mini btn-edit'
        ]);
        $this->initDefaultButton('update', '',[
            'class'=>'layui-btn layui-btn-mini btn-edit'
        ]);
        $this->initDefaultButton('resume', '',[
            'data-confirm' => Yii::t('yii', '确定要恢复吗?'),
            'data-opt'=>'del',
            'class'=>'layui-btn layui-btn-mini'
        ]);
        $this->initDefaultButton('delete', '', [
            'data-confirm' => Yii::t('yii', '确定要删除吗?'),
            'data-opt'=>'del',
            'class'=>'layui-btn layui-btn-mini layui-btn-danger'
        ]);
    }

    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', '查看');
                        break;
                    case 'update':
                        $title = Yii::t('yii', '编辑');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', '删除');
                        break;
                    case 'resume':
                        $title = Yii::t('yii', '恢复');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                ], $this->buttonOptions, $additionalOptions);
                return Html::a($title, $url, $options);
            };
        }
    }
}