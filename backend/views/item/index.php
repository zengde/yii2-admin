<?php

use yii\helpers\Url;

$this->title = '角色&权限列表';
$this->params['breadcrumbs'][] = $this-> title;
$list=$dataProvider->getModels();

?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">
        <form class="layui-form" action="" method="get">
            <input type="hidden" value="item/index" name="r" />
            <a href="javascript:;" class="layui-btn" data-opt="edit" data-act="add" data-url="create">
                <i class="layui-icon">&#xe608;</i> 添加<?=$labels['type']?>
            </a>

            <div class="layui-inline" style="float:right;">
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" name="name" value="<?=$searchModel['name']?>" autocomplete="off" class="layui-input" placeholder="请输入<?=$labels['type']?>名" required  lay-verify="required">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
            </div>
        </form>
    </blockquote>
    <fieldset class="layui-elem-field">
        <legend><?=$labels['type']?>列表</legend>
        <div class="layui-field-box">
            <table class="site-table table-hover">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th >名称 </th >
                    <th >描述 </th >
                    <th >规则 </th >
                    <th width="150">操作 </th >
                </tr>
                </thead>
                <tbody>
                <?php $i=1;foreach($list as $vo):?>
                    <tr>
                        <td><?=$i++?></td>
                        <td><?=$vo->name?></td>
                        <td><?=$vo->description?></td>
                        <td><?=$vo->ruleName?></td>
                        <td>
                            <a href="<?=Url::to(['view','id'=>$vo->name])?>" data-opt="view" class="layui-btn layui-btn-normal layui-btn-mini">查看</a>
                            <a href="javascript:;" data-act="edit" data-url="update&id=<?=$vo->name?>" data-opt="edit" class="layui-btn layui-btn-mini">编辑</a>
                            <a href="javascript:;" data-id="<?=$vo->name?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </fieldset>
    <div class="admin-table-page">
        <div id="page" class="page">
            <?= \backend\widgets\MyLinkPager::widget([
                'pagination'=>$dataProvider->getPagination(),
            ]) ?>
        </div>
    </div>
</div>
<script>
    layui.config({
        base: weburl+'js/'
    });

    layui.use(['form','layer'], function() {
        var $ = layui.jquery,
            layer = parent.layer === undefined ? layui.layer : parent.layer;
        var label='<?=$labels['type']?>';
        $('a[data-opt="edit"]').on('click', function() {
            url=$(this).data('url');
            act=$(this).data('act');
            title=(act=='edit')? '编辑'+label:'添加'+label;
            $.get(commonurl+url, null, function(content) {
                layer.open({
                    type: 1,
                    title: title,
                    content: content,
                    btn: ['保存', '取消'],
                    area: ['700px', '450px'],
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
                            form.on('select(route)', function(data){
                                if(data.value=='0')
                                    top.$('.route-input').val('');
                                else
                                    top.$('.route-input').val(data.value);
                            });
                        });
                    }
                });
            });
        });

        $('a[data-opt="del"]').on('click', function() {
            uid=$(this).data('id');
            layer.confirm('确定要删除吗?', {icon: 5, title:'提示'}, function(index){
                location.href=commonurl+'delete&id='+uid;
                layer.close(index);
            });
        });

        $('a[data-opt="view"]').on('click',function(){
            url=$(this).attr('href');
            $.get(url, null, function(content) {
                layer.open({
                    type: 1,
                    title: '查看'+label,
                    content: content,
                    btn: ['确定', '取消'],
                    area: ['900px', '650px'],
                    maxmin: true,
                    yes: function(index) {
                        layer.close(index);
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
                        top.layui.use(['route_layui'],function(){
                            var route = top.layui.route_layui;
                            route.init();
                        });
                    }
                });
            });
            return false;
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
    });
</script>