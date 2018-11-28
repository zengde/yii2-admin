<?php

use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $searchModel \backend\models\searchs\ExpressSearch */
/** @var $dataProvider \yii\data\ActiveDataProvider */
$list=$dataProvider->getModels();
?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">
        <form class="layui-form" action="" method="get">
            <input type="hidden" value="express/index" name="r" />
            <a href="<?=Url::to(['create'])?>" class="layui-btn btn-edit" title="添加">
                <i class="layui-icon">&#xe608;</i> 添加
            </a>

            <div class="layui-inline" style="float:right;">
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" name="name" autocomplete="off" class="layui-input" placeholder="请输入" required  lay-verify="required">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
            </div>
        </form>
    </blockquote>
    <fieldset class="layui-elem-field">
        <legend>物流列表</legend>
        <div class="layui-field-box">
            <table class="display layui-table table-hover" cellspacing="0">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th>名称</th>
                    <th>地址</th>
                    <th>联系人</th>
                    <th>手机</th>
                    <th>QQ</th>
                    <th>Email</th>
                    <th>网址</th>
                    <th>添加日期</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=0;foreach($list as $vo):$i++;?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$vo['name']?></td>
                        <td><?=$vo['address']?></td>
                        <td><?=$vo['cperson']?></td>
                        <td><?=$vo['cellphone']?></td>
                        <td><?=$vo['qq']?></td>
                        <td><?=$vo['email']?></td>
                        <td><?=$vo['website']?></td>
                        <td><?=$vo['adddate']?></td>
                        <td>
                            <a href="<?=Url::to(['update','id'=>$vo['id']])?>" title="编辑" class="layui-btn layui-btn-mini btn-edit">编辑</a>
                            <a href="<?=Url::to(['delete','id'=>$vo['id']])?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <?php if(empty($list)):echo '无相关记录';endif;?>
        </div>
        <div class="layui-field-box">
            <div id="page" class="page">
                <?= \backend\widgets\common\LinkPages::widget([
                    'pagination'=>$dataProvider->getPagination(),
                ]) ?>
            </div>
        </div>
    </fieldset>
</div>
<script>
    layui.config({
        base: weburl+'js/'
    });

    layui.use(['layer'], function() {
        var $ = layui.jquery,
            layer = parent.layer === undefined ? layui.layer : parent.layer;
        //page

        $('a.btn-edit').on('click', function() {
            url=$(this).attr('href');
            title=$(this).attr('title');
            cusconfig={};
            $.get(url, null, function(content) {
                layer.open($.extend({
                    type: 1,
                    title: title,
                    content: content,
                    btn: ['保存', '取消'],
                    area: ['700px', '510px'],
                    maxmin: true,
                    yes: function(index) {
                        ajaxform_file(top.$('.form-ajax'),function(json){
                            if(json.status==1){
                                layer.close(index);
                                location.reload();
                            }else{
                                layer.alert(json.info, {icon: 5});
                            }
                        });
                    },
                    full: function(elem) {
                        var win = window.top === window.self ? window : parent.window;
                        $(win).on('resize', function() {
                            var $this = $(this);
                            elem.width($this.width()).height($this.height()).css({
                                top: 0,
                                left: 0
                            });
                            elem.children('div.layui-layer-content').height($this.height() - 95);
                        });

                    },
                    success: function(layero, index){
                        top.layui.use(['form'],function(){
                            var form = top.layui.form();
                            form.render();
                        });
                    }
                },cusconfig));
            });
            return false;
        });
        $('a[data-opt="del"]').on('click', function() {
            url=$(this).attr('href');
            layer.confirm('确定要删除吗?', {icon: 5, title:'提示'}, function(index){
                $.get(url,null,function(data){
                    location.reload();
                });
                layer.close(index);
            });
            return false;
        });

        $('.layui-table tbody tr').on('click', function(event) {
            var $this = $(this);
            if($this.hasClass('selected')){
                $this.removeClass('selected').css('background','none');
            }else{
                $this.parent().find('.selected').css('background','none').removeClass('selected');
                $this.addClass('selected').css('background','#d2d2d2')
            }
        });
    });
</script>