<?php

use App\Config\Config;
use Core\Router;

require_once '../vendor/autoload.php';
require_once '../helpers/functions/functions.php';
require_once '../helpers/functions/sessionHelper.php';

$BASE = Config::URL_BASE;

$routes = require_once 'routes.php';

// Router
$router = new Router();
$router->dispatch($routes);
