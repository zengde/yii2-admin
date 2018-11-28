<?php
/**
 * Created by IntelliJ IDEA.
 * User: zeng
 * Date: 2017-06-10
 * Time: 15:42
 */

namespace backend\widgets\layui;

use yii\widgets\BaseListView;

class GridView extends \yii\grid\GridView
{
    public $tableOptions = ['class' => 'layui-table table-hover'];
    public $layout = "{items}\n{pager}";

    public $pager = ['class'=>'backend\widgets\common\LinkPages'];

    public function run()
    {
        BaseListView::run();
    }
}