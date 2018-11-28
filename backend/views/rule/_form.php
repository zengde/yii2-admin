<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthRule */

?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <form class="layui-form form-ajax" action="<?=Url::to()?>" method="post">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label">类名</label>
                <div class="layui-input-block">
                    <input type="text" name="classname" value="<?=$model::className()?>" class="layui-input">
                </div>
            </div>
        </form>
    </div>

</div>
