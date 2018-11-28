<?php

use yii\helpers\Html;
use backend\widgets\layui\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Group */
/* @var $form ActiveForm */
?>
<div class="layui-layout layui-layout-admin">
    <div class="layui-main group-form">

        <?php $form = ActiveForm::begin([
            'options'=>['class'=>'layui-form form-ajax']
        ]); ?>

        <hr>
        <div class="layui-form-item">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="layui-form-item">
            <?= $form->field($model, 'status')->switchCheck() ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>