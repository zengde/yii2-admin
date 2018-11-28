<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '菜单';
?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">
        <form class="layui-form" action="<?=Url::to()?>" method="post">
            <a href="<?=Url::to(['create'])?>" class="layui-btn btn-edit" title="创建菜单">
                <i class="layui-icon">&#xe608;</i> 创建菜单
            </a>

            <div class="layui-inline" style="float:right;">
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" name="name" autocomplete="off" class="layui-input" placeholder="请输入菜单名" required  lay-verify="required">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
            </div>
        </form>
    </blockquote>
    <fieldset class="layui-elem-field">
        <legend>菜单列表</legend>
        <div class="layui-field-box">
            <table class="layui-table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>路由</th>
                    <th>排序</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=0;foreach($menu as $vo):?>
                    <tr>
                        <td><?=++$i?></td>
                        <td><?=$vo['name']?></td>
                        <td><?=$vo['route']?></td>
                        <td><?=$vo['order']?></td>
                        <td>
                            <a href="<?=Url::to(['update','id'=>$vo['id']])?>" title="编辑菜单" class="layui-btn layui-btn-mini btn-edit">编辑</a>
                            <a href="<?=Url::to(['delete','id'=>$vo['id']])?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                            <a href="<?=Url::to(['create','id'=>$vo['id']])?>" title="添加子菜单" class="layui-btn layui-btn-normal layui-btn-mini btn-edit">
                                <i class="fa fa-link"></i> 添加子菜单
                            </a>
                        </td>
                    </tr>
                    <?php if(!empty($vo['children'])):?>
                        <?php $j=0;foreach($vo['children'] as $v):$j++?>
                            <tr>
                                <td><?=$i.'-'.$j?></td>
                                <td><?='&nbsp;&nbsp;&nbsp;&nbsp;├─'.$v['name']?></td>
                                <td><?=$v['route']?></td>
                                <td><?=$v['order']?></td>
                                <td>
                                    <a href="<?=Url::to(['update','id'=>$v['id']])?>" title="编辑菜单" class="layui-btn layui-btn-mini btn-edit">编辑</a>
                                    <a href="<?=Url::to(['delete','id'=>$v['id']])?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
                </tbody>
            </table>
            <?php if(empty($menu)):echo '无相关记录';endif;?>
        </div>
    </fieldset>
</div>
<script>
    var cuslayerconfig={
        area: ['700px', '580px'],
        success: function(layero, index){
            top.layui.use(['form'],function(){
                var form = top.layui.form();
                form.render();
                form.on('select(route)',function (data) {
                    top.$('.route-input').val(data.value);
                })
            });
        }
    };
</script>
<?=Html::jsFile('@web/js/app_layui.js')?>