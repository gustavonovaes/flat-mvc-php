<?php

namespace App;

use App\Exceptions\NotFoundException;

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => [],
        'UPDATE' => [],
        'DELETE' => []
    ];

    public function get($uri, $callback)
    {
        $this->add('GET', $uri, $callback);
    }

    public function post($uri, $callback)
    {
        $this->add('POST', $uri, $callback);
    }

    public function update($uri, $callback)
    {
        $this->add('UPDATE', $uri, $callback);
    }

    public function delete($uri, $callback)
    {
        $this->add('DELETE', $uri, $callback);
    }

    public function dispatch()
    {
        $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {
            $method = isset($_POST['_method']) ? $_POST['_method'] : 'POST';

            if (!isset($this->routes[$method])) {
                throw new \RuntimeException("'{$method}' is not a valid method");
            }
        }

        $uris = array_keys($this->routes[$method]);

        foreach ($uris as $uri) {

            if (preg_match("#^{$uri}$#", $request_uri) !== 1) {
                continue;
            }

            return call_user_func($this->routes[$method][$uri]);
        }

        throw new NotFoundException("Any '{$method}' route match with uri '{$request_uri}'");
    }

    private function add($method, $uri, $callback)
    {
        $this->routes[$method][$uri] = $callback;
    }
}