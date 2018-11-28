<?php

use yii\helpers\Url;

$this->title = '规则列表';

?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">
        <form class="layui-form" action="" method="get">
            <input type="hidden" value="rule/index" name="r" />
            <a href="<?=Url::to(['create'])?>" class="layui-btn" data-opt="edit" data-act="add">
                <i class="layui-icon">&#xe608;</i> 添加规则
            </a>

            <div class="layui-inline" style="float:right;">
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" name="name" value="" autocomplete="off" class="layui-input" placeholder="请输入规则名" required  lay-verify="required">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
            </div>
        </form>
    </blockquote>
    <fieldset class="layui-elem-field">
        <legend>规则列表</legend>
        <div class="layui-field-box">
            <table class="site-table table-hover">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th >名称 </th >
                    <th >类名 </th >
                    <th >创建时间 </th >
                    <th width="150">操作 </th >
                </tr>
                </thead>
                <tbody>
                <?php $i=1;foreach($rules as $vo):?>
                    <tr>
                        <td><?=$i++?></td>
                        <td><?=$vo->name?></td>
                        <td><?=$vo::className()?></td>
                        <td><?=date('Y-m-d H:i:s',$vo->createdAt)?></td>
                        <td>
                            <a href="<?=Url::to(['delete','name'=>$vo->name])?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </fieldset>
    <div class="admin-table-page">
        <div id="page" class="page">

        </div>
    </div>
</div>
<script>
    layui.config({
        base: weburl+'js/'
    });

    layui.use(['form','icheck','layer'], function() {
        var $ = layui.jquery,
            layer = parent.layer === undefined ? layui.layer : parent.layer;
        var label='规则';
        $('a[data-opt="edit"]').on('click', function() {
            url=$(this).attr('href');
            act=$(this).data('act');
            title=(act=='edit')? '编辑'+label:'添加'+label;
            $.get(url, null, function(content) {
                layer.open({
                    type: 1,
                    title: title,
                    content: content,
                    btn: ['保存', '取消'],
                    area: ['700px', '250px'],
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
            return false;
        });

        $('a[data-opt="del"]').on('click', function() {
            uid=$(this).attr('href');
            layer.confirm('确定要删除吗?', {icon: 5, title:'提示'}, function(index){
                location.href=commonurl+'delete&id='+uid;
                layer.close(index);
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
