<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">

    <link rel="shortcut icon" href="<?=Url::to('@web/favicon.ico')?>">
    <script>
        var appurl = '<?= Yii::$app->homeUrl ?>';
        var controller='<?= Yii::$app->controller->getUniqueId() ?>';
        var commonurl = appurl+'?r='+controller+'/';
        var weburl='<?= Url::to('@web/') ?>';
        var publicurl = '<?= Url::to('@web/public') ?>';
    </script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php
if(Yii::$app->controller->module->requestedRoute!=""
    && Yii::$app->controller->module->requestedRoute!="site/login"):?>
<nav class="breadcrumb">
    <div class="pull-right">
        <a class="layui-btn" href="javascript:history.go(-1);" title="后退">
            <i class="fa fa-reply"></i>
        </a>
        &nbsp;
        <a class="layui-btn" href="javascript:location.replace(location.href);" title="刷新">
            <i class="fa fa-refresh"></i>
        </a>
        &nbsp;
    </div>
</nav>
<?php endif;?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
