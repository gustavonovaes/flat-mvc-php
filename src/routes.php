<?php

use App\Router;

$route = new Router();

$route->add('/', 'App\Controllers\PeopleController::show');

return $route;