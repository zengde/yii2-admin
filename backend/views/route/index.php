<?php

use yii\helpers\Url;
use yii\helpers\Json;

/* @var $this yii\web\View */

$opts = Json::htmlEncode([
    'routes' => $routes
]);
$this->registerJs("var _opts = {$opts};",$this::POS_HEAD);
$this->registerJsFile("@web/js/route.js?v4");
?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <fieldset class="layui-elem-field layui-field-title site-title">
            <legend>路由列表</legend>
        </fieldset>
        <div class="layui-form-item">
            <div class="layui-input-inline" style="width: 93%;">
                <input id="inp-route" type="text" name="price_min" placeholder="新的路由(路由-描述)" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-input-inline" style="width: 4%;">
                <button href="<?=Url::to(['create'])?>" id="btn-new" class="layui-btn">添加</button>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline" style="width: 46%">
                <div class="layui-input-inline" style="width: 100%">
                    <input type="text" name="" placeholder="未分配" autocomplete="off" class="layui-input search" data-target="avaliable">
                    <button id="btn-refresh" class="layui-btn" style="display: none;">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <select style="display: block;width: 100%;height: 500px;" multiple="" size="20" class=" list" data-target="avaliable">
                        <?php foreach($routes['avaliable'] as $item):
                            echo '<option value="'.$item.'">'.$item.'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>
            <div class="layui-inline" style="width: 4%">
                <a href="<?=Url::to(['assign'])?>" class="layui-btn layui-btn-normal btn-assign" data-target="avaliable" title="分配">
                    >>
                </a>
                <br><br>
                <a href="<?=Url::to(['remove'])?>" class="layui-btn layui-btn-danger btn-assign" data-target="assigned" title="删除">
                    <<
                </a>
            </div>
            <div class="layui-inline" style="width: 46%">
                <div class="layui-input-inline" style="width: 100%">
                    <input type="text" name="" placeholder="已分配" autocomplete="off" class="layui-input search" data-target="assigned">
                    <select style="display: block;width: 100%;height: 500px;" multiple="" size="20" class=" list" data-target="assigned">
                        <?php foreach($routes['assigned'] as $key=>$item):
                            echo '<option value="'.$item.'">'.$item.'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>