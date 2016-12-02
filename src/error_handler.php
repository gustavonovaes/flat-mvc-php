<?php

set_exception_handler(function ($e) {

    $response = [
        'status' => 500,
        'title' => 'Erro Interno',
        'code' => $e->getCode(),
        'line' => $e->getLine(),
        'file' => $e->getFile(),
        'message' => $e->getMessage(),
    ];

    if (!is_dev()) {
        $response['message'] = 'No keyboard detected press f1 to continue';
        $response = filter($response, ['status', 'title', 'message']);
    }

    if ($e instanceof \App\Exceptions\NotFoundException) {
        $response['status'] = 404;
        $response['title'] = '404 - Not Found';
        $response['message'] = $e->getMessage();
    }

    if ($e instanceof \App\Exceptions\ValidationException) {
        $response['status'] = 400;
        $response['message'] = $e->getMessage();
    }

    $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']);

    if ($is_ajax) {
        json($response, $response['status']);
    }

    view('error', $response, $response['status']);
});

set_error_handler(function ($errno, $errstr) {
    throw new Exception($errstr, $errno);
}, E_ALL);