<?php

use App\Route;

$route = new Route();

$route->add('/', 'App\Controllers\PeopleController::show');

return $route;