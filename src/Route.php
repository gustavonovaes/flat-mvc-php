<?php

namespace App;

class Route
{
    private $routes = [];

    public function add($uri, $callback)
    {
        $this->routes[$uri] = $callback;
    }

    public function dispach()
    {
        $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uris = array_keys($this->routes);

        foreach ($uris as $uri) {

            if (preg_match("#^{$uri}$#", $request_uri) !== 1) {
                continue;
            }

            return call_user_func($this->routes[$uri]);
        }

        throw new \RuntimeException('Not found');
    }
}