<?php

use App\Router;

$route = new Router();

$route->get('/', 'App\Controllers\PeopleController::show');

return $route;