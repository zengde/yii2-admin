<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$opts = \yii\helpers\Json::htmlEncode([
    'items' => $items
]);
echo Html::script("var _opts = {$opts};");
?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <fieldset class="layui-elem-field layui-field-title site-title">
            <legend>权限列表</legend>
        </fieldset>
        <div class="layui-form-item">
            <div class="layui-inline" style="width: 44%">
                <div class="layui-input-inline" style="width: 100%">
                    <input type="text" name="" placeholder="可分配" autocomplete="off" class="layui-input search" data-target="avaliable">
                    <button id="btn-refresh" class="layui-btn" style="display: none;">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <select style="display: block;width: 100%;height: 400px;" multiple="" size="20" class=" list" data-target="avaliable">
                        <?php foreach($items['avaliable'] as $item):
                            echo '<option value="'.$item.'">'.$item.'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>
            <div class="layui-inline" style="width: 6%">
                <a data-href="<?=Url::to(['assign','id'=>$id])?>" class="layui-btn layui-btn-normal btn-assign" data-target="avaliable" title="分配">
                    >>
                </a>
                <br><br>
                <a data-href="<?=Url::to(['revoke','id'=>$id])?>" class="layui-btn layui-btn-danger btn-assign" data-target="assigned" title="删除">
                    <<
                </a>
            </div>
            <div class="layui-inline" style="width: 45%">
                <div class="layui-input-inline" style="width: 100%">
                    <input type="text" name="" placeholder="已分配" autocomplete="off" class="layui-input search" data-target="assigned">
                    <select style="display: block;width: 100%;height: 400px;" multiple="" size="20" class=" list" data-target="assigned">
                        <?php foreach($items['assigned'] as $item):
                            echo '<option value="'.$item.'">'.$item.'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
