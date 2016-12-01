<?php

use App\Database\DB;

/** Load to .env to global $_ENV  */
load_env();

$pdo = new PDO(
    env('DB_DSN',  'mysql:host=127.0.0.1;dbname=db'),
    env('DB_USER', 'root'),
    env('DB_PASS', 'toor'),
    [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_EMULATE_PREPARES => true,
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ]
);

DB::setPDO($pdo);

$config = [
    'view_path' => realpath(__DIR__ . '/../src/Views'),
];

$_ENV = array_merge($_ENV, $config);