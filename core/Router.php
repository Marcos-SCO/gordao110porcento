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
    protected function convertToCamelCase($string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    public function getUrl()
    {
        $url = $_SERVER['QUERY_STRING'];
        $url = $this->removeQueryStringVariables($url);
        if ($url) {
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

    public function dispatch()
    {
        $url = $this->getUrl();

        if (isset($url)) {
            // Controller
            if (isset($url[0])) {
                $this->controller = $this->convertToCamelCase($url[0]);
                unset($url[0]);
            }
            // Method
            if (isset($url[1])) {
                $this->method = $this->convertToStudlyCaps($url[1]);
                unset($url[1]);
            }
            // Param
            foreach ($url as $params) {
                $this->params[] = $params;
            }
        }
        dump($this->params);

        $controller = 'App\Controllers\\' . $this->controller;

        if (class_exists($controller)) {
            $controller_object = new $controller($this->params);

            call_user_func_array([$controller_object, $this->method], $this->params);
        } else {
            throw new \Exception("Controller class $controller not found");
        }
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
            // explode(separator,string,limit)
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }
}
