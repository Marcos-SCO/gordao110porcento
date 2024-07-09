<?php

namespace App\Request;

class PostRequest extends RequestData
{

  public static function postFieldsValidation()
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $title = trim(indexParamExistsOrDefault($post, 'title', ''));

    $notAllowedTags = array('<script>', '<a>');
    $body = trim(indexParamExistsOrDefault($post, 'body', ''));
    $body = str_replace($notAllowedTags, '', $body);

    if ($title) $data['title'] = $title;
    if ($body) $data['body'] = $body;

    if (empty($data['title'])) {

      $errorData['title_error'] = "Coloque o título.";
    }

    if (empty($data['body'])) {

      $errorData['body_error'] = "Preencha o campo de texto.";
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }
}
