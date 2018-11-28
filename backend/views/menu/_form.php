<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <form class="layui-form form-ajax" action="<?=Url::to()?>" method="post" enctype="multipart/form-data">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>基本信息</legend>
            </fieldset>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" value="<?=$model['name']?>" placeholder="请输入名称" autocomplete="off" class="layui-input" lay-verify="required">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-inline">
                        <input type="number" name="order" value="<?=$model['order']?>" autocomplete="off" class="layui-input" lay-verify="number">
                    </div>
                </div>

            </div>
            <div class="layui-form-item" style="margin-top: 20px;">
                <div class="layui-inline">
                    <label class="layui-form-label">路由</label>
                    <div class="layui-input-inline">
                        <input type="text" name="route" value="<?=$model['route']?>" placeholder="请输入路由" autocomplete="off" class="layui-input route-input" lay-verify="required">
                    </div>
                </div>
                <div class="layui-inline">
                    <select lay-filter="route" lay-search>
                        <option value=''>请选择</option>
                        <?php foreach($routes as $name=>$item):
                            $selected=($model->route==$name)? 'selected':'';
                            echo '<option value="'.$name.'"'.$selected.'>'.$name.'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">父级</label>
                <div class="layui-input-block">
                    <select name="parentid" lay-search>
                        <option value=''>请选择</option>
                        <?php foreach($model->getAllMenu() as $item):
                            $selected=($model->parentid==$item->id)? 'selected':'';
                            echo '<option value="'.$item->id.'"'.$selected.'>'.$item->name.'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>

            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>附加信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label">数据</label>
                <div class="layui-input-block">
                    <textarea name="data" class="layui-textarea"><?=$model['data']?></textarea>
                </div>
            </div>
        </form>
    </div>

</div>
