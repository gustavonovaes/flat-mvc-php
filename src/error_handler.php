<?php

set_exception_handler(function ($e) {

    if ($e instanceof \App\Exceptions\NotFoundException) {
        return view('error', [
            'title' => '404 - Not Found',
            'message' => '404',
        ]);
    }

    view('error', [
        'title' => 'Erro Interno',
        'message' => 'No keyboard detected press f1 to continue.'
    ]);
});

set_error_handler(function ($errno, $errstr) {
    throw new Exception($errstr, $errno);
}, E_ALL);