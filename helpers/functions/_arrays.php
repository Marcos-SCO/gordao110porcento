<?php

function combineRecursiveArrays($array1, $array2)
{
  $merged = $array1;

  foreach ($array2 as $key => $value) {

    if (!isset($merged[$key]) || empty($merged[$key])) {

      $merged[$key] = $value; // Prioritize non-empty values
      
      continue;
    }

    if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {

      $merged[$key] = combineRecursiveArrays($merged[$key], $value); // Recursively merge nested arrays

    }
  }

  return $merged;
}
