<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yii\db\ActiveRecord */

?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <form class="layui-form form-ajax" action="<?=Url::to()?>" method="post" enctype="multipart/form-data">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>基本信息</legend>
            </fieldset>

            <div class="layui-form-item">
                <label class="layui-form-label">物流名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" value="<?=$model['name']?>" placeholder="请输入名称" autocomplete="off" class="layui-input" lay-verify="required">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">地址</label>
                <div class="layui-input-block">
                    <input type="text" name="address" value="<?=$model['address']?>" placeholder="请输入地址" autocomplete="off" class="layui-input" lay-verify="required">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">联系人</label>
                    <div class="layui-input-inline">
                        <input type="text" name="cperson" value="<?=$model['cperson']?>" placeholder="请输入联系人" autocomplete="off" class="layui-input" lay-verify="required">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">手机</label>
                    <div class="layui-input-inline">
                        <input type="number" name="cellphone" value="<?=$model['cellphone']?>" placeholder="请输入手机号" autocomplete="off" class="layui-input" lay-verify="number">
                    </div>
                </div>

            </div>

            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>附加信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">QQ</label>
                    <div class="layui-input-block">
                        <input type="number" name="qq" class="layui-input" value="<?=$model['qq']?>">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">Email</label>
                    <div class="layui-input-block">
                        <input type="email" name="email" class="layui-input" value="<?=$model['email']?>">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">网址</label>
                <div class="layui-input-block">
                    <input type="url" name="website" value="<?=($model['website'])?>" class="layui-input">
                </div>
            </div>
        </form>
    </div>

</div>
