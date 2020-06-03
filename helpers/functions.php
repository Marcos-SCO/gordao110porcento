<?php

// dump information

use App\Config\Config;

function dump($item)
{
    echo '<pre style="font-size:1.3rem;">';
    var_dump($item);
    echo '</pre>';
    return;
}
// Get query strings
function getQueryString()
{
    $url = explode('/', $_SERVER['QUERY_STRING']);
    // Get table with url
    $table = $url[0] ?? '';
    $method = $url[1] ?? '';
    $id = $url[2] ?? '';
    return [$table, $method, $id];
}

// Date format
function dateFormat($data)
{
    $date = date_create($data);
    return date_format($date, "d/m/Y \\a\s H:i:s");
}

function imgOrDefault($table, $img, $id, $tableOp = '') {
    if ($img !== null) {
        $path = "public/img/$table$tableOp/id_$id/$img";
    } else {
        $path = "public/img/$table/default/default.png";
    }
    return $path;
}

// Simple page redirect
function redirect($page)
{
    header('Status: 301 Moved Permanently', false, 301);
    header('Location: ' . Config::URL_BASE . '/' . $page);
    die();
}
