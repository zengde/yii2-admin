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
                    <select name="companyid" lay-search>
                        <option value='0'>请选择</option>
                        <?php foreach($express as $id=>$vo):
                            $selected=($vo['id']==$model['companyid'])? ' selected="selected"':'';
                        echo '<option value="'.$vo['id'].'"'.$selected.'>'.$vo['name'].'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">地址</label>
                <div class="layui-input-block">
                    <select id="select_tree" name="areaid" data-areaid="<?=$model['areaid']?>" lay-search>

                    </select>
                </div>
            </div>

            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>附加信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:100px;">抛货价(元/立方)</label>
                    <div class="layui-input-inline">
                        <input type="number" name="sizeprice" class="layui-input" value="<?=$model['sizeprice']?>">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:100px;">重货价(元/公斤)</label>
                    <div class="layui-input-inline">
                        <input type="number" name="weightprice" class="layui-input" value="<?=$model['weightprice']?>">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label" style="width:100px;">运送时间(天)</label>
                <div class="layui-input-inline">
                    <input type="number" name="sendtime" value="<?=($model['sendtime'])?>" class="layui-input">
                </div>
            </div>
        </form>
    </div>

</div>
