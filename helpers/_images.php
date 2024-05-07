<?php 

// Show a image or default in src
function imgOrDefault($table, $img, $id, $tableOp = '')
{
    if ($img !== null) return "public/resources/img/$table$tableOp/id_$id/$img";

    $isUserTable = $table == 'users';

    if ($isUserTable) return "public/resources/img/$table/default/default.png";

    if (!$isUserTable) return "public/resources/img/default/default.png";
}