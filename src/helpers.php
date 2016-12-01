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