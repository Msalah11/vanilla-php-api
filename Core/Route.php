<?php

namespace App\Core;

use App\Exceptions\NotFoundException;
use Exception;

class Route
{
    /**
     * All registered routes.
     *
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    /**
     * Load routes file.
     *
     * @param string $file
     * @return Route
     */
    public static function load(string $file): Route
    {
        $router = new static;
        require $file;
        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param array $controller
     */
    public function get(string $uri, array $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param array $controller
     */
    public function post(string $uri, array $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Register a PUT route.
     *
     * @param string $uri
     * @param array $controller
     */
    public function put(string $uri, array $controller)
    {
        $this->routes['PUT'][$uri] = $controller;
    }


    /**
     * Register a DELETE route.
     *
     * @param string $uri
     * @param array $controller
     */
    public function delete(string $uri, array $controller)
    {
        $this->routes['DELETE'][$uri] = $controller;
    }

    /**
     * Load the requested URI's associated controller method.
     *
     * @param string $uri
     * @param string $requestType
     * @return mixed
     * @throws Exception
     */
    public function call(string $uri, string $requestType)
    {
        $callback = array_key_exists($uri, $this->routes[$requestType]) ?? false;

        if (!$callback) {
            throw new NotFoundException();
        }

        return $this->callAction(
            reset($this->routes[$requestType][$uri]),
            end($this->routes[$requestType][$uri])
        );
    }

    /**
     * Load and call the relevant controller action.
     *
     * @param string $controller
     * @param string $action
     * @return mixed
     * @throws Exception
     */
    protected function callAction(string $controller, string $action)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;
        $middlewares = $controller->getMiddlewares();
        foreach ($middlewares as $middleware) {
            $middleware->handle();
        }
        if (!method_exists($controller, $action)) {
            throw new Exception(
                "{$controller} does not have the {$action} method."
            );
        }

        return $controller->$action();
    }
}