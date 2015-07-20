<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@app/../common/cache'
        ],
        'tools' => [
            'class' => 'common\components\Tools'
        ],
        'setting' => [
            'class' => 'common\components\Setting',
        ],
        'assetManager' => [
            'forceCopy' => YII_DEBUG ? true : false,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_DEBUG ? 'jquery.js' : '//cdn.bootcss.com/jquery/2.1.4/jquery.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_DEBUG ? 'css/bootstrap.css' : '//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapThemeAsset' => [
                    'css' => [
                        YII_DEBUG ? 'css/bootstrap-theme.css' : '//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_DEBUG ? 'js/bootstrap.js' : '//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js',
                    ]
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'=>false
        ],
    ],
];
