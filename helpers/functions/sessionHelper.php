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
Exemple - flash('register_success', 'You are now registered');
Display in view - <?php echo flash('register_success');
*/
function flash($name = '', $message = '', $class = 'alert alert-success')
{
    return $_SESSION['flashMessage'] = [
        'name' => $name,
        'message' => $message,
        'class' => $class
    ];
}

function displayFlashMessage()
{
    $flashMessage =
        indexParamExistsOrDefault($_SESSION, 'flashMessage');

    if (!$flashMessage) return;

    $flashClass = indexParamExistsOrDefault($flashMessage, 'class');
    $flashMessage = indexParamExistsOrDefault($flashMessage, 'message');

    echo "<div class='" . $flashClass . "' id='msg-flash' style='transition: transform .18s, opacity .18s, visibility 0s .18s;position:absolute;left:5%;top:17%;text-align: center;z-index:9999999999;'>" . $flashMessage . "</div>
    
    <script>
        let flash = document.querySelector('#msg-flash'); 
        if (flash) {
            setTimeout(() => { 
                flash.style = 'display:none;transition: transform .18s, opacity .18s, visibility 0s .18s;'; 
            }, 4000); 
        }
    </script>";

    unset($_SESSION['flashMessage']);
}

function isLoggedIn()
{
    $userSessionId = indexParamExistsOrDefault($_SESSION, 'user_id');
    $haveUserSession = valueParamExistsOrDefault($userSessionId);

    if (!$haveUserSession) return false;

    return true;
}

function isSubmittedInSession()
{
    return isset($_SESSION['submitted']);
}

function addSubmittedToSession()
{
    return $_SESSION['submitted'] = true;
}

function removeSubmittedFromSession()
{
    if (!isSubmittedInSession()) return;

    unset($_SESSION['submitted']);
}
