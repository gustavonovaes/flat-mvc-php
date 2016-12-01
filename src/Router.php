<?php

namespace App;

use App\Exceptions\NotFoundException;

class Router
{
    private $routes = [];

    public function add($uri, $callback)
    {
        $this->routes[$uri] = $callback;
    }

    public function dispatch()
    {
        $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uris = array_keys($this->routes);

        foreach ($uris as $uri) {

            if (preg_match("#^{$uri}$#", $request_uri) !== 1) {
                continue;
            }

            return call_user_func($this->routes[$uri]);
        }

        throw new NotFoundException("Any route match with '{$request_uri}'");
    }
}