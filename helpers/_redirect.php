<?php

use App\Config\Config;

// Simple page redirect
function redirect($page)
{
    header('Status: 301 Moved Permanently', false, 301);
    header('Location: ' . Config::URL_BASE . '/' . $page);

    die();
}