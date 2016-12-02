<?php

use App\Router;

$route = new Router();

$route->get('/', 'App\Controllers\PeopleController::show');

$route->post('/people', 'App\Controllers\PeopleController::store');

$route->put('/people', 'App\Controllers\PeopleController::update');

$route->delete('/people', 'App\Controllers\PeopleController::delete');

return $route;