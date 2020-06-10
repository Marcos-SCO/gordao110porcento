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

// Show a image or default in src
function imgOrDefault($table, $img, $id, $tableOp = '') {
    if ($img !== null) {
        $path = "public/img/$table$tableOp/id_$id/$img";
    } else {
        if ($table == 'users') {
            $path = "public/img/$table/default/default.png";
        } else {
            $path = "public/img/default/default.png";
        }
    }
    return $path;
}

// Detect if ua is IE
function detectIE() {
    $ua= htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8' ); 
    if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0' ) !== false && strpos($ua, 'rv:11.0' ) !== false)) { 
        return true;
    }
    return false;
}

// Simple page redirect
function redirect($page)
{
    header('Status: 301 Moved Permanently', false, 301);
    header('Location: ' . Config::URL_BASE . '/' . $page);
    die();
}
