<?php

use App\Route;

$route = new Route();

$route->add('/', function () {
    view('test', ['test' => 'Works!']);
});

return $route;