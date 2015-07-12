<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@app/../common/cache'
        ],
        'setting' => [
            'class' => 'common\components\Setting',
        ],
        'assetManager' => [
            'forceCopy' => (YII_DEBUG) ? true : false
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'=>false
        ],
    ],
   
];
