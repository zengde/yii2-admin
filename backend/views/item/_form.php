<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <form class="layui-form form-ajax" action="<?=Url::to()?>" method="post">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="<?=$model['name']?>" class="layui-input route-input" lay-verify="required">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <input type="text" name="description" value="<?=$model['description']?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">规则</label>
                <div class="layui-input-block">
                    <input type="text" class="layui-input" value="<?=$model['rule_name']?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">数据</label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
                </div>
            </div>

        </form>
    </div>

</div>
