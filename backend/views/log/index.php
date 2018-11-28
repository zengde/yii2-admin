<?php

use yii\helpers\Html;
use backend\widgets\layui\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '日志列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-main log-index">

    <fieldset class="layui-elem-field">
        <legend><?= Html::encode($this->title) ?></legend>
        <div class="layui-field-box">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label'=>'级别',
                        'value'=>function($model,$key,$index,$column){
                            return \yii\log\Logger::getLevelName($model['level']);
                        }
                    ],
                    'category',
                    'log_time:datetime',
                    [
                        'class' => 'backend\widgets\layui\ActionColumn',
                        'visibleButtons'=>['delete'=>false,'update'=>false],
                        'headerOptions'=>['width'=>45]
                    ],
                    //'message:ntext',
                ],
            ]); ?>
        </div>
    </fieldset>
</div>
<?=Html::jsFile('@web/js/app_layui.js')?>