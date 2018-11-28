<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main">
        <form class="layui-form form-ajax" action="<?=Url::to()?>" method="post" enctype="multipart/form-data">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>基本信息</legend>
            </fieldset>

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="username" value="<?=$model['username']?>" placeholder="请输入用户名" autocomplete="off" class="layui-input" required>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" autocomplete="off" class="layui-input">
                    </div>
                </div>

            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">部 门</label>
                <div class="layui-input-block">
                    <select name="groupid">
                        <option value="">请选择</option>
                        <?php foreach($groups as $name=>$item):
                            $selected=(!$model->isNewRecord&&$model->groupid==$item->id)? 'selected':'';
                            echo '<option value="'.$item->id.'"'.$selected.'>'.$item->name.'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>
            <div class="layui-form-item" style="margin-top: 20px;">
                <label class="layui-form-label">权限组</label>
                <div class="layui-input-block">
                    <select name="rolename">
                        <option value="">请选择</option>
                        <?php foreach($roles as $name=>$item):
                            $selected=(!$model->isNewRecord&&$model->assign&&$model->assign->item_name==$name)? 'selected':'';
                            echo '<option value="'.$name.'"'.$selected.'>'.$item->description.'</option>';
                        endforeach;?>
                    </select>
                </div>
            </div>

            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>详细信息</legend>
            </fieldset>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">真实姓名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="realname" value="<?=$model['realname']?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">电话</label>
                    <div class="layui-input-inline">
                        <input type="text" name="phone" value="<?=$model['phone']?>" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">Email</label>
                    <div class="layui-input-inline">
                        <input type="email" name="email" value="<?=$model['email']?>" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">QQ</label>
                    <div class="layui-input-inline">
                        <input type="number" name="qq" value="<?=$model['qq']?>" class="layui-input">
                    </div>
                </div>
            </div>

        </form>
    </div>

</div>
