<?php

function limitChars($str, $limit, $stringEnd = '', $alwaysShowStringEnd = false)
{
  $explodeStr = explode(' ', $str);
  $strLength = strlen($str);

  $slicedArray = array_slice($explodeStr, 0, $limit);

  $stringEnd =
    ($strLength > $limit) || $alwaysShowStringEnd
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

function stringSlugFormat($slug)
{
  $slugToLower = mb_strtolower($slug);
  
  // Replace non-letter or digits with hyphens
  $string = preg_replace('/[^a-z0-9-]/', '-', $slugToLower);

  // Replace multiple hyphens with a single hyphen
  $string = preg_replace('/-+/', '-', $string);

  // Trim hyphens from the beginning and end of the string
  $string = trim($string, '-');

  return $string;
}
