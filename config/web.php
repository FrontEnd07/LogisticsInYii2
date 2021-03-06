<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => $_SERVER['HTTP_HOST'],
    'layout' => "logistics/main",
    // 'layoutPath' => '@app/views/logistics',
    'defaultRoute' => 'logistics/home/index-api',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                "add-tracker" => "logistics/tracker/add-tracker",
                "add-tracker-other-site" => "logistics/tracker/add-tracker-other-site",
                "tracker" => "logistics/tracker/tracker",
                "delete" => "logistics/tracker/delete-tracker",
                "import" => "logistics/tracker/import",
                "add-progress" => "logistics/tracker/add-progress",
                "signup" => "logistics/user/signup",
                "signin" => "logistics/user/signin",
                "add-tracker-client" => "logistics/user/add-tracker-client",
                "my-tracker" => "logistics/user/my-tracker",
                "delete-tracker" => "logistics/user/delete-tracker",
                "my-address" => "logistics/user/address",
                "setting-account" => "logistics/user/change-account",
                "admin-tracker-list" => "logistics/admin/admin-tracker-list",
            ],
        ],
        'request' => [
            'baseUrl' => '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Zz6U2mIS4QF8Ob9MDE6wxHSGrZuMK9e-',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.beget.com',
                'username' => 'info@cargo7999.kz',
                'password' => 'm2&4G9mF',
                'port' => '2525',
                'encryption' => 'tls',
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
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
