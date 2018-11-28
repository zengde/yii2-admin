<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '分类';
$opts = \yii\helpers\Json::htmlEncode($list);
?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">

            <a href="<?=Url::to(['create'])?>" class="layui-btn btn-edit" title="创建分类">
                <i class="layui-icon">&#xe608;</i> 创建分类
            </a>
            <a href="<?=Url::to(['create'])?>" data-selected="true" class="layui-btn btn-edit" title="添加子分类">
                <i class="layui-icon">&#xe608;</i> 添加子分类
            </a>
            <a href="<?=Url::to(['update'])?>" data-selected="true" class="layui-btn btn-edit" title="修改分类">
                <i class="layui-icon">&#xe642;</i> 修改
            </a>
            <a href="<?=Url::to(['delete'])?>" data-selected="true" data-opt="del" class="layui-btn layui-btn-danger" title="删除分类">
                <i class="layui-icon">&#xe640;</i> 删除
            </a>

    </blockquote>
    <fieldset class="layui-elem-field">
        <legend>分类列表</legend>
        <div class="layui-field-box">
            <table class="layui-table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>名称</th>
                    <th>缩略图</th>
                    <th>可筛选</th>
                    <th>可输入</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=0;foreach($list as $vo):?>
                    <tr data-id="<?=$vo['id']?>">
                        <td><?=++$i?></td>
                        <td><?=$vo['name']?></td>
                        <td><?=$vo['app_img']?></td>
                        <td><?=$vo['is_show']?></td>
                        <td><?=$vo['is_input']?></td>
                        <td>
                            <a href="<?=Url::to(['update','id'=>$vo['id']])?>" title="编辑" class="layui-btn layui-btn-mini btn-edit">编辑</a>
                            <a href="<?=Url::to(['delete','id'=>$vo['id']])?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                            <a href="<?=Url::to(['create','id'=>$vo['id']])?>" title="添加子分类" class="layui-btn layui-btn-normal layui-btn-mini btn-edit">
                                <i class="fa fa-link"></i> 添加子分类
                            </a>
                        </td>
                    </tr>
                    <?php if(!empty($vo['children'])):?>
                        <?php $j=0;foreach($vo['children'] as $v):$j++?>
                            <tr data-id="<?=$v['id']?>">
                                <td><?=$i.'-'.$j?></td>
                                <td><?='&nbsp;&nbsp;&nbsp;&nbsp;├─'.$v['name']?></td>
                                <td><?=$v['app_img']?></td>
                                <td><?=$v['is_show']?></td>
                                <td><?=$v['is_input']?></td>
                                <td>
                                    <a href="<?=Url::to(['update','id'=>$v['id']])?>" title="编辑" class="layui-btn layui-btn-mini btn-edit">编辑</a>
                                    <a href="<?=Url::to(['delete','id'=>$v['id']])?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                                    <a href="<?=Url::to(['create','id'=>$v['id']])?>" title="添加子分类" class="layui-btn layui-btn-normal layui-btn-mini btn-edit">
                                        <i class="fa fa-link"></i> 添加子分类
                                    </a>
                                </td>
                            </tr>
                            <?php if(!empty($v['children'])):?>
                                <?php $k=0;foreach($v['children'] as $v2):$k++?>
                                    <tr data-id="<?=$v2['id']?>">
                                        <td><?=$i.'-'.$j.'-'.$k?></td>
                                        <td><?='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─'.$v2['name']?></td>
                                        <td><?=$v2['app_img']?></td>
                                        <td><?=$v2['is_show']?></td>
                                        <td><?=$v2['is_input']?></td>
                                        <td>
                                            <a href="<?=Url::to(['update','id'=>$v2['id']])?>" title="编辑" class="layui-btn layui-btn-mini btn-edit">编辑</a>
                                            <a href="<?=Url::to(['delete','id'=>$v2['id']])?>" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">删除</a>
                                            <a href="<?=Url::to(['create','id'=>$v2['id']])?>" title="添加子分类" class="layui-btn layui-btn-normal layui-btn-mini btn-edit">
                                                <i class="fa fa-link"></i> 添加子分类
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
                </tbody>
            </table>
            <?php if(empty($list)):echo '无相关记录';endif;?>
        </div>
    </fieldset>
</div>
<script>
    var cat_list = <?=$opts?>;
    function list_tree_option(datas,selected,level) {
        var res='';
        for(var i in datas){
            data=datas[i];
            str=level>0? Array(level).fill("&nbsp;&nbsp;&nbsp;&nbsp;")+'├─':'';
            selectedstr=(selected==data.id)? 'selected':'';
            res+="<option value='"+data.id+"' "+selectedstr+">"+str+data.name+"</option>"
            if(data.children){
                res+=list_tree_option(data.children,selected,level+1)
            }
        }
        return res;
    }

    layui.config({
        base: weburl+'js/'
    });

    layui.use(['form', 'laypage','layer'], function() {
        var $ = layui.jquery,
            laypage = layui.laypage,
            layer = parent.layer === undefined ? layui.layer : parent.layer;
        //page

        $('a.btn-edit').on('click', function() {
            url=$(this).attr('href');
            is_need_selected=$(this).data('selected');
            if(is_need_selected){
                selected=$('.layui-table tbody tr.selected');
                if(!selected.length){
                    layer.alert('请先选择分类！', {icon: 5});
                    return false;
                }
                url+='&id='+selected.data('id');
            }
            title=$(this).attr('title');
            cusconfig={};
            $.get(url, null, function(content) {
                layer.open($.extend({
                    type: 1,
                    title: title,
                    content: content,
                    btn: ['保存', '取消'],
                    area: ['700px', '620px'],
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
                            var selectobj=top.$('#cat_parent');
                            var options=list_tree_option(cat_list,selectobj.data('parentid'),0);
                            selectobj.append(options);
                            form.render();
                        });
                    }
                },cusconfig));
            });
            return false;
        });
        $('a[data-opt="del"]').on('click', function() {
            url=$(this).attr('href');
            is_need_selected=$(this).data('selected');
            if(is_need_selected){
                selected=$('.layui-table tbody tr.selected');
                if(!selected.length){
                    layer.alert('请先选择分类！', {icon: 5});
                    return false;
                }
                url+='&id='+selected.data('id');
            }
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