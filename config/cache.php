<?php
return [
//            'class' => 'yii\caching\FileCache',
    'class' => 'yii\caching\DbCache',
    // 'db' => 'mydb',
    'cacheTable' => 'app_cache',
];
