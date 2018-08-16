<?php
return [
    'class' => 'yii\redis\Session',
    'redis' => [
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 2,
    ],
    'name' => 'BTSESSID',
    'keyPrefix' => 'session_',
    'timeout' => 86400, //一天
];