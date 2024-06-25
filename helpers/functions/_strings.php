<?php

function limitChars($str, $limit, $stringEnd = '', $alwaysShowStringEnd = false)
{
  $explodeStr = explode(' ', $str);
  $slicedArray = array_slice($explodeStr, 0, $limit);
  
  $stringEnd =
    (count($explodeStr) > $limit) || $alwaysShowStringEnd
    ? $stringEnd : '';

  return substr(implode(' ', $slicedArray), 0, $limit) . $stringEnd;
}

function limitWords($str, $limit, $stringEnd = '')
{
  $explodeStr = explode(' ', $str);
  $slicedArray = array_slice($explodeStr, 0, $limit);
  $stringEnd = count($explodeStr) > $limit ? $stringEnd : '';

  return implode(' ', $slicedArray) . $stringEnd;
}

function limitStringWith($string, $limitWith = 'words', $limitNum = 10, $delimiter = '')
{
  return $limitWith == 'words'
    ? limitWords($string, $limitNum, $delimiter)
    : limitChars($string, $limitNum, $delimiter);
}

function returnStringForLabelInArray(string $labelSearchedString, array $labelsArray)
{
  if (!$labelsArray) return $labelSearchedString;

  return isset($labelsArray[$labelSearchedString])
    ? $labelsArray[$labelSearchedString]
    : $labelSearchedString;
}

function singularOrPluralString($singularString, $pluralString, $return = 'singular')
{
  return $return == 'singular'
    ? $singularString : $pluralString;
}


function removeNonNumericValues($value = '')
{
  return preg_replace('/\D/', '', $value);
}
