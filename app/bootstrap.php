<?php

use Core\Router;

require '../vendor/autoload.php';
require '../helpers/functions.php';

/**
 * Time zone São Paulo
 */
date_default_timezone_set('America/Sao_Paulo');

/**
 * Error and Exception handling
 */
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

// Routes
// require '../routes/routes.php';

$core = new Router();
