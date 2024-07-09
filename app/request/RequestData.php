<?php

namespace App\Request;

class RequestData
{

  public static function getPostData()
  {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    return $post;
  }

  public static function isErrorInRequest(array $errorData)
  {
    if (!isset($errorData['error'])) return false;

    $isErrorArray = is_array($errorData['error']);
    if (!$isErrorArray) return $errorData['error'];

    $foundError = isset($errorData['error']) && array_filter($errorData['error'], function ($item) {
      return $item && $item === true;
    });;

    return $foundError;
  }
}
