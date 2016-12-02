<?php

set_exception_handler(function ($e) {

    $response = [
        'status' => 500,
        'title' => 'Erro Interno',
        'message' => is_dev() ? $e->getMessage(): 'No keyboard detected press f1 to continue.',
    ];

    if ($e instanceof \App\Exceptions\NotFoundException) {
        $response = [
            'status' => 404,
            'title' => '404 - Not Found',
            'message' => $e->getMessage(),
        ];
    }

    $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

    if ($is_ajax) {
        header('Content-type: application/json');
        http_response_code($response['status']);
        die($response['message']);
    }

    view('error', $response, $response['status']);
});

set_error_handler(function ($errno, $errstr) {
    throw new Exception($errstr, $errno);
}, E_ALL);