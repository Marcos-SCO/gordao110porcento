<?php

use App\Config\Config;
use Core\Router;

require_once '../vendor/autoload.php';
require_once '../helpers/functions.php';
require_once '../helpers/sessionHelper.php';

$BASE = Config::URL_BASE;

// Router
$router = new Router();
