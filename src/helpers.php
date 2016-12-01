<?php

function load_env()
{
    if (!$ini = @parse_ini_file(__DIR__ . '/../.env')) {
        throw new RuntimeException('Failed to load .env file');
    }

    $_ENV = array_merge($_ENV, $ini);
}

function env($key, $default = null)
{
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }

    if ($default !== null) {
        return $default;
    }

    return null;
}

function view ($template, array $data = [])
{
    extract($data);

    $path = env('view_path') . "/{$template}.php";

    if (!is_readable($path)) {
        throw new InvalidArgumentException('Template not exists');
    }

    include $path;
}