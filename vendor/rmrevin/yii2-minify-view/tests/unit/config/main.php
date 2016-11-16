<?php
/**
 * main.php
 * @author Roman Revin http://phptime.ru
 */

define('BASE_PATH', realpath(__DIR__ . '/..'));

return [
    'id' => 'testapp',
    'basePath' => BASE_PATH,
    'components' => [
        'view' => [
            'class' => 'rmrevin\yii\minify\View',
            'minify_path' => BASE_PATH . '/runtime/minyfy',
            'base_path' => BASE_PATH . '/runtime',
            'web_path' => '/runtime',
            'force_charset' => 'CP1251',
        ],
        'assetManager' => [
            'basePath' => BASE_PATH . '/runtime/assets',
            'baseUrl' => '/assets',
        ],
    ],
];