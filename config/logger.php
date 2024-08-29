<?php

use yii\log\Logger;

$psrLogger = new \Monolog\Logger('shirakalu');
$psrLogger->pushHandler(new \Monolog\Handler\StreamHandler(Yii::getAlias('@logs/monolog.log'), \Monolog\Logger::DEBUG));


return [
    'traceLevel' => YII_DEBUG ? 3 : 0,
    'flushInterval' => 1,
    'targets' => [
        [
            'class' => 'samdark\log\PsrTarget',
            'logger' => $psrLogger,
            'logVars' => [],
            'except' => [
                'yii\db\Command::query',
                'yii\db\Command::execute',
                'yii\web\HttpException:401',
                'yii\web\HttpException:404',
            ],
            'levels' => [Logger::LEVEL_ERROR, Logger::LEVEL_WARNING, Logger::LEVEL_INFO, Logger::LEVEL_TRACE],
            'addTimestampToContext' => true,
        ],
        'file' => [
            'class' => 'yii\log\FileTarget',
            'maxFileSize' => 10240, //in KB
            'maxLogFiles' => 5,
            'rotateByCopy' => true,
            'levels' => ['error', 'warning'],
            'logVars' => [],
            'except' => [
                'yii\db\Command::query',
                'yii\web\HttpException:401',
                'yii\web\HttpException:404',
            ],
            'logFile' => '@logs/app.log',
        ],
        [
            'class' => 'yii\log\FileTarget',
            'logFile' => '@logs/http-request.log',
            'categories' => ['yii\httpclient\*'],
        ],
    ],
];
