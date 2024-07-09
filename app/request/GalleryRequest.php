<?php

namespace App\Request;

class GalleryRequest extends RequestData
{

  public static function galleryFieldsValidation()
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $imgTitle = indexParamExistsOrDefault($post, 'img_title');

    if ($imgTitle) $data['img_title'] = trim($imgTitle);

    if (empty($data['img_title'])) {
      $errorData['img_title_error'] = "Coloque uma descrição para imagem";
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }
}
