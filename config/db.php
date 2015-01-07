<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:dbname=diancan;host=localhost',
    'username' => 'dog',
    'password' => '18007551615zhh',
    'attributes'=> [
        PDO::ATTR_PERSISTENT => true,
    ],
    'charset' => 'utf8',
];