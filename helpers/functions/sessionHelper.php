<?php
// Start Session
session_start();

// Session variables
isset($_SESSION['user_status']) ? $_SESSION['user_status'] : $_SESSION['user_status'] = null;

isset($_SESSION['user_id']) ? $_SESSION['user_id'] : $_SESSION['user_id'] = null;

isset($_SESSION['adm_id']) ? $_SESSION['adm_id'] : $_SESSION['adm_id'] = null;

isset($_SESSION['user_email']) ? $_SESSION['user_email'] : $_SESSION['user_email'] = null;

isset($_SESSION['user_name']) ? $_SESSION['user_name'] : $_SESSION['user_name'] = null;

/**
 * Time zone São Paulo
 */
date_default_timezone_set('America/Sao_Paulo');

ini_set('default_charset', 'UTF-8');

/**
 * Error and Exception handling
 */
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

// Flash message helper
/*
EXEMPLE - flash('register_sucess', 'You are now registered');
DISPLAY IN VIEW - <?php echo flash('register_sucess');
*/
function flash($name = '', $message = '', $class = 'alert alert-success')
{
    return  [
        'name' => $name,
        'message' => $message,
        'class' => $class
    ];
}

function isLoggedIn()
{
    $userSessionId = indexParamExistsOrDefault($_SESSION, 'user_id');
    $haveUserSession = valueParamExistsOrDefault($userSessionId);

    if (!$haveUserSession) return false;

    return true;
}
