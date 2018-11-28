<?php

use yii\helpers\Url;

/** @var  $searchModel \backend\models\searchs\ProductSearch */
/** @var  $dataProvider \frontend\data\MyDataProvider */
$this->title = '产品列表';
$list=$dataProvider->getModels();
?>
<div class="admin-main">
    <blockquote class="layui-elem-quote">
        <form class="layui-form" action="" method="get">
            <input type="hidden" value="product/index" name="r" />
            <div class="layui-inline" style="float:right;">
                <div class="layui-input-inline" style="width: 200px;">
                    <input type="text" name="name" value="<?=$searchModel['name']?>" autocomplete="off" class="layui-input" placeholder="请输入产品名" required  lay-verify="required">
                </div>
                <button type="submit" class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
            </div>
            <div class="layui-clear"></div>
        </form>
    </blockquote>
    <fieldset class="layui-elem-field">
        <legend>产品列表</legend>
        <div class="layui-field-box">
            <table class="layui-table table-hover">
                <thead>
                <tr>
                    <th width="20">#</th>
                    <th width="200">产品名称</th>
                    <th width="150">最后更新</th>
                    <th width="120">产品分类</th>
                    <th width="120">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($list as $i=>$vo):?>
                    <tr>
                        <td><?=$i+1?></td>
                        <td><?=$vo['name']?></td>
                        <td><?=$vo['last_time']?></td>
                        <td><?=$vo['catname']?></td>
                        <td>
                            <a href="<?=Url::to(['resume','id'=>$vo['id']])?>" title="恢复" data-opt="del" class="layui-btn layui-btn-mini">恢复</a>
                            <a href="<?=Url::to(['fdelete','id'=>$vo['id']])?>" title="永久删除" data-opt="del" class="layui-btn layui-btn-danger layui-btn-mini">永久删除</a>
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
        var layer = layui.layer;

        $('a[data-opt="del"]').on('click', function() {
            url=$(this).attr('href');
            title=$(this).attr('title');
            layer.confirm('确定要'+title+'吗?', {icon: 5, title:'提示'}, function(index){
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
