<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
