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
        'assetsAutoCompress'
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
        'db' => $db,
        'assetsAutoCompress' => [
            'class' => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
            'enabled' => true,
            'jsCompress' => true,
            'jsFileCompress' => false,
            'cssFileCompile' => true,
            'jsFileCompile' => true,
        ],
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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules',
                ],
            ],
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
