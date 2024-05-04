<?php

use App\Config\Config;
use Core\Router;

require_once '../vendor/autoload.php';
require_once '../helpers/functions.php';
require_once '../helpers/sessionHelper.php';


$BASE = Config::URL_BASE;

$routes = require_once 'routes.php';

// Router
$router = new Router();
$router->dispatch($routes);
