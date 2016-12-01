<?php

set_exception_handler(function ($e) {


});

set_error_handler(function ($errno, $errstr) {
    throw new Exception($errstr, $errno);
}, E_ALL);