<?php

// Verifica se o valor existe, caso contrário retorna padrão
function valueParamExistsOrDefault($param, $default = false)
{
  return isset($param) && !empty($param)
    ? $param : $default;
}

// Verifica se o valor de um index existe dentro do array, caso contrário retorna padrão
function indexParamExistsOrDefault($array, $index, $default = false)
{
  return isset($array) && isset($array[$index]) ? $array[$index] : $default;
}

// Verifica se o valor existe em um obj
function objParamExistsOrDefault($obj, $param, $default = false)
{
  if (!is_object($obj)) return $default;

  return isset($obj) && isset($obj->$param) ? $obj->$param : $default;
}

function verifyValue($data, $param, $verifyType = 'array', $default = false)
{
  if ($verifyType == 'array') {
    return valueParamExistsOrDefault(indexParamExistsOrDefault($data, $param), $default);
  }
  
  if ($verifyType == 'obj') {
    return valueParamExistsOrDefault(objParamExistsOrDefault($data, $param), $default);
  }
}

// Verifica se categoria tem posts
function categoryHasPosts($category, $postType = 'post')
{
  return count(get_posts(['post_type' => $postType, 'posts_per_page' => 1, 'fields' => 'ids', 'category_name' => $category])) > 0;
}
