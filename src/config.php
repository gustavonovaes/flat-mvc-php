<?php

/** Load to .env to global $_ENV  */
load_env();

$config = [
    'view_path' => realpath(__DIR__ . '/../src/Views'),
];

$_ENV = array_merge($_ENV, $config);