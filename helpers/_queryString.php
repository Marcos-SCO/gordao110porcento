<?php 

// Get query strings
function getQueryString()
{
    $url = explode('/', $_SERVER['QUERY_STRING']);

    // remove query strings
    if (strpos($url[0], '=') == true) {
        $url[0] = '';
        $url[1] = '';
    };

    // Get table with url
    $table = $url[0] ?? '';
    $method = $url[1] ?? '';
    $id = $url[2] ?? '';

    return [$table, $method, $id];
}