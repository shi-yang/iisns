<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$db = require(__DIR__ . '/../../common/config/db.php');

return [
    'id' => 'iiSNS-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'setting' => [
            'class' => 'backend\modules\setting\SettingModule',
        ],
        'forum' => [
            'class' => 'backend\modules\forum\ForumModule',
            'aliases' => [
                '@forum_icon' => '@web/uploads/forum/icon/', //图标上传路径
                '@avatar' => '@web/uploads/user/avatar/',
                '@photo' => '@web/uploads/blog/photo/'
            ],
        ],
        'rbac' => [
            'class' => 'backend\modules\rbac\Module',
            'layout' => 'left-menu',
        ]
    ],
    'components' => [
        'db' => $db,
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
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
    'as access' => [
        'class' => 'backend\modules\rbac\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/logout',
            'site/error',
            'site/captcha'
            //'rbac/*'
            // The actions listed here will be allowed to everyone including guests.
        ]
    ],
    'params' => $params,
];
