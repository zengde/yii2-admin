<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <form class="layui-form form-ajax" action="<?=Url::to()?>" method="post" enctype="multipart/form-data">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" value="<?=$model['name']?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <input type="text" name="description" value="<?=$model['description']?>" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">Rule</label>
                <div class="layui-input-block">
                    <input type="text" name="rule_name" value="<?=$model['rule_name']?>" class="layui-input">
                </div>
            </div>

        </form>
    </div>

</div>
