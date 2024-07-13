<?php

namespace App\Request;

class GalleryRequest extends RequestData
{

  public static function galleryFieldsValidation()
  {
    $post = self::getPostData();

    $imgTitle = indexParamExistsOrDefault($post, 'img_title');

    if ($imgTitle) self::$data['img_title'] = trim($imgTitle);

    if (empty(self::$data['img_title'])) {
      self::$errorData['img_title_error'] = "Coloque uma descrição para imagem";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
