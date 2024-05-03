<?php

namespace Core;

class Router
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $this->dispatch();
    }

    /* Convert the string with hyphens to SturdlyCaps
    e.g. post-author => PostAuthor */
    protected function convertToStudlyCaps($string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /* Convert the string with hyphens to camelCase
    e.g. add new => addNew */
    protected function convertToUc($string): string
    {
        return ucfirst($this->convertToStudlyCaps($string));
    }

    public function getUrl()
    {
        $url = $_SERVER['QUERY_STRING'];
        $url = str_replace('public/index.php', $url, '');

        $url = rtrim($url, "/");
        $url = $this->removeQueryStringVariables($url);

        if (!$url) return false;

        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        return $url;
    }

    public function dispatch()
    {
        $url = $this->getUrl();

        // Controller
        if (isset($url[0])) {
            $this->controller = $this->convertToUc($url[0]);
            unset($url[0]);
        }

        // Method
        if (isset($url[1])) {
            $this->method = $this->convertToStudlyCaps($url[1]);
            unset($url[1]);
        }

        // Params
        $urlHasParams = $url ? count($url) : false;

        if ($urlHasParams) {

            foreach ($url as $params) {
                $this->params[] = $params;
            }
        }
        //dump($this->params);

        $controller = 'App\Controllers\\' . $this->controller;

        $classExists = class_exists($controller);

        if (!$classExists) throw new \Exception("Controller: class <b>$controller</b> not found");

        $controllerObject = new $controller($this->params);

        $methodExists = method_exists($controllerObject, $this->method);

        if (!$methodExists) throw new \Exception("Method: <b>{$this->method}</b> not found");

        call_user_func_array([$controllerObject, $this->method], $this->params);
    }

    /**
     * Remove the query string variables from the URL (if any). As the full query string is used for the route, any variables at the end will need to be removed before the route is matched to the routing table. For example:
     *   URL $_SERVER['QUERY_STRING']  Route
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *localhost/posts?page=1 posts&page=1 posts
     *localhost/posts/index  posts/index posts/index
     *localhost/posts/index?page=1  posts/index&page=1 posts/index
    
     * A URL of the format localhost/?page (one variable name, no value) won't work however. (NB. The .htaccess file converts the first ? to a & when it's passed through to the $_SERVER variable).
     *
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            // explode(separator, string, limit)
            $parts = explode('&', $url, 2);

            $isUrlParams = strpos($parts[0], '=') === false;

            $url = $isUrlParams ? $parts[0] : '';
        }

        return $url;
    }
}
