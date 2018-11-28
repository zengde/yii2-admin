<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '角色列表';
?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">
        <a href="javascript:;" class="layui-btn" data-opt="edit" data-act="add">
            <i class="layui-icon">&#xe608;</i> 添加角色
        </a>
        <a href="javascript:;" class="layui-btn layui-btn-normal" data-opt="auth">
            <i class="layui-icon">&#xe612;</i> 权限管理
        </a>
    </blockquote>
    <fieldset class="layui-elem-field">
        <legend>用户组列表</legend>
        <div class="layui-field-box">
            <table class="site-table table-hover ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>角色名</th>
                    <th>描述</th>
                    <th>规则</th>
                    <th>创建时间</th>
                    <th width="180">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=0;foreach($roles as $vo):$i++;?>
                    <tr data-id="<?=$vo->name?>">
                        <td><?=$i?></td>
                        <td><?=$vo->name?></td>
                        <td><?=$vo->description?></td>
                        <td><?=$vo->ruleName?></td>
                        <td><?=date('Y-m-d H:i:s',$vo->createdAt)?></td>
                        <td>
                            <a href="javascript:;" data-id="<?=$vo->name?>" data-opt="auth" class="layui-btn layui-btn-mini layui-btn-normal">权限管理</a>
                            <a href="javascript:;" data-id="<?=$vo->name?>" data-opt="edit" data-act="edit" class="layui-btn layui-btn-mini">编辑</a>
                            <a href="javascript:;" data-id="<?=$vo->name?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </fieldset>
</div>
<script>
    layui.config({
        base: weburl+'js/'
    });

    layui.use(['form','icheck', 'laypage','layer'], function() {
        var $ = layui.jquery,
            laypage = layui.laypage,
            layer = parent.layer === undefined ? layui.layer : parent.layer;
        //page

        $('a[data-opt="edit"]').on('click', function() {
            uid=$(this).data('id');
            act=$(this).data('act');
            url=(act=='edit')? '?r=user/groupsave&id='+uid:'?r=user/groupsave';
            title=(act=='edit')? '编辑用户组':'添加用户组';
            $.get(appurl+url+'&act='+act, null, function(content) {
                layer.open({
                    type: 1,
                    title: title,
                    content: content,
                    btn: ['保存', '取消'],
                    area: ['700px', '330px'],
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
                        top.layui.use(['form','icheck'],function(){
                            var form = top.layui.form();
                            form.render();
                        });
                    }
                });
            });
        });

        $('a[data-opt="del"]').on('click', function() {
            uid=$(this).data('id');
            layer.confirm('确定要删除吗?', {icon: 5, title:'提示'}, function(index){
                //do something
                location.href=appurl+'?r=user/groupdelete&id='+uid;
            });
        });

        $('.site-table tbody tr').on('click', function(event) {
            var $this = $(this);
            if($this.hasClass('selected')){
                $this.removeClass('selected').css('background','none');
            }else{
                $this.parent().find('.selected').css('background','none').removeClass('selected');
                $this.addClass('selected').css('background','#d2d2d2')
            }
        });

        $('a[data-opt="auth"]').on('click', function() {
            uid=$(this).data('id')? $(this).data('id'):$('.site-table tbody tr.selected').data('id');
            if(!uid){
                layer.alert('请先选择要编辑的用户组！',{icon: 5});
                return;
            }
            $.get(appurl+'?r=item/assign&id='+uid, null, function(content) {
                layer.open({
                    type: 1,
                    title: '权限管理',
                    content: content,
                    btn: ['保存', '取消'],
                    area: ['700px', '530px'],
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

                    }
                });
            });
        });
    });
</script>