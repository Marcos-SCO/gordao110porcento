<?php

use App\Config\Config;
use Core\Router;

require_once '../vendor/autoload.php';
require_once '../helpers/functions/functions.php';
require_once '../helpers/functions/sessionHelper.php';

$IS_APACHE_SERVER = Config::$IS_APACHE_SERVER;

$BASE = Config::$URL_BASE;

$BASE_WITH_PUBLIC = $IS_APACHE_SERVER
    ? $BASE . '/public' : $BASE;

$RESOURCES_PATH = Config::$RESOURCES_PATH;

$routes = require_once 'routes.php';

// Router
$router = new Router();
$router->dispatch($routes);
