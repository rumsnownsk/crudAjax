<?php

if (PHP_MAJOR_VERSION < 8){
    die("Require PHP version >= 8");
}
ini_set('display_errors', 1);
error_reporting(-1);


return [
    'db'=>[
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'crudAjax',
        'username' => 'admin',
        'password' => 'admin',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'port' => 3306,
        'prefix' => '',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC    // получать всегда ассоциативный массив
        ]
    ],
    'pagination'=>[
        'perPage' => 8,
        'midSize' => 2,
        'maxPages' => 7,
        'tpl' => 'incs/pagination'
    ]

];
