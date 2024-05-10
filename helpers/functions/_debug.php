<?php 

function dump($item)
{
    echo '<pre style="font-size:1.3rem;">';
    var_dump($item);
    echo '</pre>';
    return;
}

// Detect if ua is IE
function detectIE()
{
    $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');

    if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0') !== false && strpos($ua, 'rv:11.0') !== false)) {

        return true;
    }

    return false;
}