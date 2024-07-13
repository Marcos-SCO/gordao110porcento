<?php

namespace App\Request;

use App\Classes\ImagesHandler;

class ImageRequest extends RequestData
{

  public static function validateImageParams($imageIsRequired = true)
  {
    self::$post = self::getPostData();

    $imgFiles = indexParamExistsOrDefault($_FILES, 'img');
    $imgName = indexParamExistsOrDefault($imgFiles, 'name');
    $postImg = indexParamExistsOrDefault(self::$post, 'img');

    if ($imgFiles) self::$data['img_files'] = $imgFiles;
    if ($imgName) self::$data['img_name'] = $imgName;
    if ($postImg) self::$data['post_img'] = $postImg;

    $isEmptyPostImg = $postImg == "" || $postImg == false;
    if (!$isEmptyPostImg) self::$data['img_name'] = $postImg;

    if ($imageIsRequired && empty(self::$data['img_name'])) {

      self::$errorData['error'] = true;
      self::$errorData['img_error'] = "Insira uma imagem";
    }

    if (!empty(self::$data['img_files']) && !empty(self::$data['img_name'])) {

      $imagesHandler = new ImagesHandler();

      $validatedImgRequest =
        $imagesHandler->verifySubmittedImgExtension();

      self::$errorData['error'] = $validatedImgRequest[0];
      $imgError = $validatedImgRequest[1];

      if (!empty($imgError)) {

        self::$errorData['img_error'] = $imgError;
      }
    }

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
