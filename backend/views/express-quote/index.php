<?php

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var  $searchModel \backend\models\searchs\ExpressQuoteSearch */
/** @var  $dataProvider \frontend\data\MyDataProvider */
$this->title = '物流报价';
$trees=['0'=>[
    'id'=>'0',
    'name'=>'中华人民共和国',
    'spread'=>true,
    'children'=>$trees
]];
$list=$dataProvider->getModels();
?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">
        <form class="layui-form" action="" method="get">
            <input type="hidden" value="express-quote/index" name="r" />
            <a href="<?=Url::to(['create'])?>" class="layui-btn btn-edit" title="添加报价">
                <i class="layui-icon">&#xe608;</i> 添加报价
            </a>

            <div class="layui-inline" style="float:right;">
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" name="city" value="<?=$searchModel['city']?>" autocomplete="off" class="layui-input" placeholder="请输入地址" required  lay-verify="required">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
            </div>
            <div class="layui-clear"></div>
        </form>
    </blockquote>
    <fieldset class="layui-elem-field" style="float: left;width:18%;">
        <legend>地址</legend>
        <ul id="demo"></ul>
    </fieldset>
    <fieldset class="layui-elem-field" style="float: left;width:80%;">
        <legend>报价列表</legend>
        <div class="layui-field-box">
            <table class="layui-table table-hover">
                <thead>
                <tr>
                    <th width="20">#</th>
                    <th>运送地址</th>
                    <th width="200">运送物流</th>
                    <th width="100">抛货价(元/立方)</th>
                    <th width="100">重货价(元/公斤)</th>
                    <th width="100">运送时间(天)</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list as $i=>$vo):?>
                    <tr>
                        <td><?=$i+1?></td>
                        <td><?=$searchModel->getfullCity($vo['areaid'],$vo['city'])?></td>
                        <td><?=$vo['companyname']?></td>
                        <td><?=$vo['sizeprice']?></td>
                        <td><?=$vo['weightprice']?></td>
                        <td><?=$vo['sendtime']?></td>
                        <td>
                            <a href="<?=Url::to(['update','id'=>$vo['id']])?>" class="layui-btn layui-btn-mini btn-edit" title="编辑">编辑</a>
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
    var nodes=<?=\yii\helpers\Json::htmlEncode($trees)?>;
    var activeid='<?=$searchModel['areaid']?>';

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
    layui.use(['form','layer','tree_layui'], function() {
        var layer = parent.layer === undefined ? layui.layer : parent.layer;
        layui.tree_layui.init({
            elem: '#demo' //传入元素选择器
            ,nodes: nodes
            ,click: function(obj,node){
                param=(node.id=='0')? '':'&areaid='+node.id;
                location.href=commonurl+'index'+param;
            }
            ,active:activeid
        });

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
                    area: ['800px', '510px'],
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
                            var selectobj=top.$('#select_tree');
                            var options=list_tree_option(nodes,selectobj.data('areaid'),0);
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