<?php
Yii::setAlias('@logs', dirname(__DIR__) . '/logs');

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$cache = require_once(__DIR__ . '/cache.php');
$session = require_once(__DIR__ . '/session.php');
$log = require_once(__DIR__ . '/logger.php');


$config = [
    'id' => 'app',
    'language' => 'en',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@app/node_modules', // Or specify a subdirectory if needed
        '@npm' => '@app/node_modules',
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // see settings on http://demos.krajee.com/grid#module
        ],
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'W3vEAkc-dvnSLmd4gIZlS6gLngttIdE-',
        ],
        /* custom view template */
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/basic',
                'baseUrl' => '@web/themes/basic',
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                ],
            ],
        ],
        'cache' => $cache,
        'session' => $session,
        'user' => [
            'identityClass' => 'app\common\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'formatter' => [
            //'class' => 'app\common\components\MyFormatter',
            //'dateFormat' => 'MMM d, Y',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'KES',
            'defaultTimeZone' => 'Africa/Nairobi'
            //'defaultTimeZone' OR 'timeZone' => 'Asia/Calcutta',
        ],
        'log' => $log,
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller>/<action:(update|delete|view)>/<id:\d+>' => '<controller>/<action>',
                '<module>/<controller>/<action:(update|delete|view)>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],

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
        'class' => yii\gii\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'masgeek' => [
                'class' => app\generators\model\MyModelGenerator::class,
                'templates' => [
                    'default' => '@app/generators/model/masgeek',
                ]
            ]
        ],
    ];
}

return $config;
