<?php

// Show a image or default in src
function imgOrDefault($table, $img, $id, $tableOption = '')
{
    $tablePath = $table . $tableOption;

    if ($img !== null) return "public/resources/img/$tablePath/id_$id/$img";

    $isUserTable = $table == 'users';

    if ($isUserTable) return "public/resources/img/$tablePath/default/default.png";

    if (!$isUserTable) return "public/resources/img/default/default.png";
}
