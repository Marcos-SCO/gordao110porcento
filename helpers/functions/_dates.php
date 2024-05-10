<?php

// Date format
function dateFormat($data)
{
    $date = date_create($data);
    return date_format($date, "d/m/Y \\a\s H:i:s");
}