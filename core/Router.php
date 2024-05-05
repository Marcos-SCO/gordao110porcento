<?php

namespace Core;

class Router
{
    protected function exactMatchUriInArrayRoutes($uri, $routes)
    {
        return array_key_exists($uri, $routes) ? [$uri => $routes[$uri]] : [];
    }

    protected  function regularExpressionMatchArrayRoutes($uri, $routes)
    {
        return array_filter($routes, function ($value) use ($uri) {
            $regex = str_replace('/', '\/', ltrim($value, '/'));

            return preg_match("/^$regex$/", ltrim($uri, '/'));
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function params($uri, $matchedUri)
    {
        if (empty($matchedUri)) return [];

        $matchedToGetParams = array_keys($matchedUri)[0];

        $uriArrayDifference = array_diff(
            $uri,
            explode('/', ltrim($matchedToGetParams, '/')),
        );

        return $uriArrayDifference;
    }

    protected function paramsFormat($uri, $params)
    {
        // $uri = explode('/', ltrim($uri, '/'));

        $paramsData = [];
        foreach ($params as $index => $param) {
            
            $index = $index > 0 ? $index : 1;
            $paramsData[$uri[$index - 1]] = $param;
        }
        
        return $paramsData;
    }

    protected function controller($matchedUri, $params)
    {
        [$controller, $method] = explode('@', array_values($matchedUri)[0]);

        $controllerWithNamespace = 'App\Controllers\\' . $controller;

        if (!class_exists($controllerWithNamespace)) {
            throw new \Exception('Controller <b>' . $controller . '</b> don\'t exists');
        }

        $controllerInstance = new $controllerWithNamespace();

        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception('Method <b>' . $method . '</b> don\'t exist in ' . $controller);
        }

        $controller = $controllerInstance->$method($params);

        return $controller;
    }

    public function dispatch($routes)
    {
        // $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pathInfo = $_SERVER['PATH_INFO'] ?? '/';
        $uri = parse_url($pathInfo, PHP_URL_PATH);

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $matchedUri = $this->exactMatchUriInArrayRoutes($uri, $routes[$requestMethod]);

        $params = [];

        if (empty($matchedUri)) {

            $matchedUri = $this->regularExpressionMatchArrayRoutes($uri, $routes[$requestMethod]);

            $uri = explode('/', ltrim($uri, '/'));

            $params = $this->params($uri, $matchedUri);
            $params = $this->paramsFormat($uri, $params);
        }

        if (!empty($matchedUri)) {
            return $this->controller($matchedUri, $params);
        }

        throw new \Exception("Route not found: <b>{$pathInfo}</b> ");
    }
}
