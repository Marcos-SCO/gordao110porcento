<?php 

// dump information

use App\Config\Config;

function dump($item) {
    echo '<pre style="font-size:1.3rem;">';
        var_dump($item);
    echo '</pre>';
    return;
}
// Get query strings
function getQueryString() {
    $url = explode('/', $_SERVER['QUERY_STRING']);
        // Get table with url
    $table = $url[0] ?? '';
    $method = $url[1] ?? '';
    $id = $url[2] ?? '';
    return [$table, $method, $id];
}
// Simple page redirect
function redirect($page)
{
    header('Status: 301 Moved Permanently', false, 301);
    header('Location: ' . Config::URL_BASE . '/' . $page);
    die();
}