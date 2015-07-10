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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'=>false,
            'rules' => [

            ],
        ],
    ],
   
];
