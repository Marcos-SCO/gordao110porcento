<?php

// Show a image or default in src
function imgOrDefault($table, $img, $id, $tableOption = '')
{
    $tablePath = $table . $tableOption;

    if ($img !== null) return "/resources/img/$tablePath/id_$id/$img";

    $isUserTable = $table == 'users';

    if ($isUserTable) return "/resources/img/$tablePath/default/default.png";

    if (!$isUserTable) return "/resources/img/default/default.png";
}

function getImgWithAttributes($imgPath, $imgAtributes = [])
{
    global $BASE;

    $imgUrl = $BASE . '/' . $imgPath;

    $errorImgUrl = $BASE  . '/resources/img/not_found/no_image.jpg';

    $attributesString = '';

    foreach ($imgAtributes as $attributeKey => $attributeParam) {
        
        $attributesString .=
            $attributeKey . '=\'' . $attributeParam . '\'';
    }

    return "<img src='$imgUrl' onerror=\"this.onerror=null;this.src='$errorImgUrl';\" $attributesString>";
}
