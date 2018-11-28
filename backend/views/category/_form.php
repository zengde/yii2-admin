<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Category */

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
                        <input type="number" name="listorder" value="<?=$model['listorder']?>" autocomplete="off" class="layui-input" lay-verify="number">
                    </div>
                </div>

            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">父级</label>
                <div class="layui-input-block">
                    <select id="cat_parent" name="parentid" data-parentid="<?=$model['parentid']?>" lay-search>
                        <option value='0'>空</option>

                    </select>
                </div>
            </div>

            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>附加信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label">可筛选</label>
                <div class="layui-input-inline">
                    <input type="checkbox" name="is_show"  value="1" <?=($model['is_input'])? 'checked':''?> lay-skin="switch">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">可输入</label>
                <div class="layui-input-inline">
                    <input type="checkbox" name="is_input" value="1" <?=($model['is_input'])? 'checked':''?> lay-skin="switch">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">缩略图</label>
                <div class="layui-input-block">
                    <div class="layui-box layui-upload-button">
                        <input type="file" name="app_img" class="layui-upload-file" lay-type="images">
                        <span class="layui-upload-icon"><i class="layui-icon"></i>上传图片</span>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
