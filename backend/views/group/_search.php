<?php

use yii\helpers\Html;
use backend\widgets\layui\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\searchs\GroupSearch */
/* @var $form ActiveForm */
?>

<div class="group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= Html::a('<i class="layui-icon">&#xe608;</i> 添加部门', ['create'], ['class' => 'layui-btn btn-edit']) ?>

    <div class="layui-inline" style="float:right;">
        <?= $form->field($model, 'name')->inline(true) ?>
        <?= Html::submitButton('搜索', ['class' => 'layui-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
