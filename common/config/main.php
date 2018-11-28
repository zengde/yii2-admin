<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'user' => [
            'class'=>'yii\web\user',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    //'levels' => ['error', 'warning','trace'],
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
         'authManager'=>[
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['admin', 'author'],
        ],
        'formatter' => [
            'dateFormat' => 'yyyy年MM月dd日',
            'datetimeFormat'=>'yyyy年MM月dd日 HH时mm分ss秒',
            'locale'=>'zh-CN',
        ]
    ],
];
