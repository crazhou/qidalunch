<?php
$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'waimaibao',
    'name' => '企大外卖宝',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'layout' => 'main', // 是否使用Layout 文件
    'layoutPath' => '@app/views/layouts',//  layout 文件目录
    'defaultRoute' => 'entry',
    'charset' => 'utf-8',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'entry/<short:\w{2,3}>' => 'entry/u',
                'user/<action:(dian|admin)>/<short:\w+>' => 'user/<action>'
            ]
        ],
        'view' => [
          'defaultExtension' => 'html'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'pDh2RlplgiNko4ebJNlbUYYK69bqMzKd',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'entry/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
