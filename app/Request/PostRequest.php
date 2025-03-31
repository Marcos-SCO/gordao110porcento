<?php

namespace App\Request;

class PostRequest extends RequestData
{

  public static function postFieldsValidation()
  {
    self::$post = self::getPostData();

    $title = trim(indexParamExistsOrDefault(self::$post, 'title', ''));

    $notAllowedTags = array('<script>', '<a>');
    $body = trim(indexParamExistsOrDefault(self::$post, 'body', ''));
    $body = str_replace($notAllowedTags, '', $body);

    if ($title) self::$data['title'] = $title;
    if ($body) self::$data['body'] = $body;

    if (empty(self::$data['title'])) {

      self::$errorData['title_error'] = "Coloque o título.";
    }

    if (empty(self::$data['body'])) {

      self::$errorData['body_error'] = "Preencha o campo de texto.";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
