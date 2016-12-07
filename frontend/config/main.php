<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$db = require(__DIR__ . '/../../common/config/db.php');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'user/dashboard',
    'modules' => [
        'forum' => [
            'class' => 'app\modules\forum\ForumModule',
            'aliases' => [
                '@forum_icon' => '@web/uploads/forum/icon/', //图标上传路径
                '@avatar' => '@web/uploads/user/avatar/',
                '@photo' => '@web/uploads/blog/photo/'
            ],
        ],
        'user' => [
            'class' => 'app\modules\user\UserModule',
            'aliases' => [
                '@avatar' => '@web/uploads/user/avatar/',
                '@photo' => '@web/uploads/home/photo/'
            ]
        ],
        'home' => [
            'class' => 'app\modules\home\HomeModule',
            'aliases' => [
                '@avatar' => '@web/uploads/user/avatar/',
                '@photo' => '@web/uploads/home/photo/'
            ]
        ],
    ],
    'components' => [
        'view' => [
            'class' => '\rmrevin\yii\minify\View',
            //'enableMinify' => !YII_DEBUG,
            'enableMinify' => true,
            'concatCss' => true, // concatenate css
            'minigfyCss' => true, // minificate css
            'concatJs' => true, // concatenate js
            'minifyJs' => true, // minificate js
            'minifyOutput' => true, // minificate result html page
            'web_path' => '@web', // path alias to web base
            'base_path' => '@webroot', // path alias to web base
            'minify_path' => '@webroot/assets', // path alias to save minify result
            'js_position' => [ \yii\web\View::POS_END ], // positions of js files to be minified
            'force_charset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expand_imports' => true, // whether to change @import on content
            'compress_options' => ['extra' => true], // options for compress
            'excludeBundles' => [
                \shiyang\umeditor\UMeditorAsset::class,
                \common\widgets\laydate\LayDateAsset::class
            ],

            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules',
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                '/' => '/user/dashboard/index',
                '<id:[\x{4e00}-\x{9fa5}a-zA-Z0-9_]*>' => 'user/view',
                '@<id:[\x{4e00}-\x{9fa5}a-zA-Z0-9_]*>' => 'forum/forum/view',
                'thread/<id:\d+>' => 'forum/thread/view',
                'p/<id:\d+>' => 'user/view/view-post'
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'userData' => [
            'class' => 'app\modules\user\models\UserData',
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
