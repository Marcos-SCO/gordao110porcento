<?php

function htmlMinifier($code)
{
  $search = [
    // Remove white spaces after tags
    '/\>[^\S ]+/s',
    // Remove white spaces before tags
    '/[^\S ]+\</s',
    // Remove multiple whitespace sequences
    '/(\s)+/s',
    // Removes comments
    '/<!--(.|\s)*?-->/'
  ];

  $replace = array('>', '<', '\\1');
  $code = preg_replace($search, $replace, $code);
  return $code;
}
