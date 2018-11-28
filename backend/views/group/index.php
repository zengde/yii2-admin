<?php

use yii\helpers\Html;
use backend\widgets\layui\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\searchs\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '部门列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-main group-index">

    <blockquote class="layui-elem-quote">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </blockquote>
    <fieldset class="layui-elem-field">
        <legend><?= Html::encode($this->title) ?></legend>
        <div class="layui-field-box">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => null,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'lastdate:datetime',
                    'statusName',

                    [
                        'class' => 'backend\widgets\layui\ActionColumn',
                        'visibleButtons'=>['view'=>false],
                        'headerOptions'=>['width'=>90]
                    ],
                ],
            ]); ?>
        </div>
    </fieldset>
</div>
<script>
    var cuslayerconfig={
        area: ['500px', '230px']
    };
</script>
<?=Html::jsFile('@web/js/app_layui.js')?>