<?php

set_exception_handler(function ($e) {

    if ($e instanceof \App\Exceptions\NotFoundException) {
        return view('not_found');
    }
});

set_error_handler(function ($errno, $errstr) {
    throw new Exception($errstr, $errno);
}, E_ALL);