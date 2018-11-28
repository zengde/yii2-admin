<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-12
 * Time: 16:02
 */
?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <div class="layui-form-item">
            <?=Yii::$app->formatter->format($model['message'],'ntext')?>
        </div>
    </div>
</div>
