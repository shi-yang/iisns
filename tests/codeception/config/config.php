<?php
$db = require(__DIR__ . '../../../../common/config/db.php');

/**
 * Application configuration shared by all applications and test types
 */
return [
    'components' => [
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
