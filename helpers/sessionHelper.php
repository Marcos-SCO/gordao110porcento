<?php
// Start Session
session_start();
/**
 * Time zone São Paulo
 */
date_default_timezone_set('America/Sao_Paulo');

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
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}
