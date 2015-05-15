<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@app/../common/cache'
        ],
        'setting' => [
            'class' => 'shiyang\setting\components\Setting',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [

            ],
        ],
    ],
   
];
