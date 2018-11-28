<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/layui/css/layui.css',
        'css/global.css',
        'plugins/font-awesome/css/font-awesome.min.css',
        'css/login.css'
    ];
    public $js = [
        'plugins/layui/layui.js',
        'js/app.js',
    ];

    public $jsOptions=['position'=>View::POS_HEAD];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}
