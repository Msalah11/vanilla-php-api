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
     * Represents the ID parameter for the route.
     *
     * @var string $params The ID parameter value.
     */
    public $params = "";

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
        foreach ($this->routes[$requestType] as $key => $value) {
            if ($uri == $key || $this->compareStrings($uri, $key)) {
                return $this->callAction(
                    reset($this->routes[$requestType][$key]),
                    end($this->routes[$requestType][$key])
                );
            }
        }

        throw new NotFoundException();
    }

    /**
     * Compare two strings to check if they match using regular expressions.
     *
     * @param string $url The URL to compare.
     * @param string $uri The URI pattern to compare against.
     * @return bool Returns true if the strings match, false otherwise.
     */
    protected function compareStrings(string $url, string $uri)
    {
        $urlPattern = $uri;
        $regexPattern = '/^' . str_replace('\{id\}', '(.+)', preg_quote($urlPattern, '/')) . '$/';

        if (!preg_match($regexPattern, $url, $matches))
            return false;

        $this->params = $matches[1];

        return true;
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

        if ($this->params == "")
            return $controller->$action();

        return $controller->$action($this->params);
    }
}
