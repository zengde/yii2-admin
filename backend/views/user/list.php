<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
$list=$dataProvider->getModels();
?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">
        <form class="layui-form" action="" method="get">
            <input type="hidden" value="user/list" name="r" />
            <a href="<?=Url::to(['create'])?>" class="layui-btn btn-edit" title="添加用户">
                <i class="layui-icon">&#xe608;</i> 添加用户
            </a>

            <div class="layui-inline" style="float:right;">
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" name="name" autocomplete="off" class="layui-input" placeholder="请输入用户名" required  lay-verify="required">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
            </div>
        </form>
    </blockquote>
    <fieldset class="layui-elem-field">
        <legend>用户列表</legend>
        <div class="layui-field-box">
            <table class="layui-table table-hover">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th>用户名</th>
                    <th>真实姓名</th>
                    <th>电话</th>
                    <th>Email</th>
                    <th>QQ</th>
                    <th>用户组</th>
                    <th width="140">上次登录时间</th>
                    <th width="90">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list as $i=>$vo):?>
                    <tr>
                        <td><?=$i+1?></td>
                        <td><?=$vo['username']?></td>
                        <td><?=$vo['realname']?></td>
                        <td><?=$vo['phone']?></td>
                        <td><?=$vo['email']?></td>
                        <td><?=$vo['qq']?></td>
                        <td><?=$vo['item']['description']?></td>
                        <td><?=date('Y-m-d H:i:s',$vo['updated_at'])?></td>
                        <td>
                            <!--
                            <a href="<?=Url::to(['assign','id'=>$vo['id']])?>" title="分配权限" class="layui-btn layui-btn-normal layui-btn-mini btn-assign">
                                <i class="fa fa-link"></i> 权限
                            </a>-->
                            <a href="<?=Url::to(['update','id'=>$vo['id']])?>" title="编辑用户" class="layui-btn layui-btn-mini btn-edit">编辑</a>
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

    layui.use(['form','layer'], function() {
        var $ = layui.jquery,
            laypage = layui.laypage,
            layer = parent.layer === undefined ? layui.layer : parent.layer;
        //page

        $('a.btn-edit,a.btn-assign').on('click', function() {
            url=$(this).attr('href');
            title=$(this).attr('title');
            cusconfig={};
            if($(this).hasClass('btn-assign')){
                cusconfig={
                    area: ['900px', '650px'],
                    success: function(layero, index){
                        top.layui.use(['route_layui'],function(){
                            var route = top.layui.route_layui;
                            route.init('group');
                        });
                    }
                };
            }
            $.get(url, null, function(content) {
                layer.open($.extend({
                    type: 1,
                    title: title,
                    content: content,
                    btn: ['保存', '取消'],
                    area: ['700px', '730px'],
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