<?php

namespace App\Request;

use App\Classes\ImagesHandler;

class ImageRequest extends RequestData
{

  public static function validateImageParams($imageIsRequired = false)
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $imgFiles = indexParamExistsOrDefault($_FILES, 'img');
    $imgName = indexParamExistsOrDefault($imgFiles, 'name');
    $postImg = indexParamExistsOrDefault($post, 'img');

    if ($imgFiles) $data['img_files'] = $imgFiles;
    if ($imgName) $data['img_name'] = $imgName;
    if ($postImg) $data['post_img'] = $postImg;
   
    $isEmptyPostImg = $postImg == "" || $postImg == false;
    if (!$isEmptyPostImg) $data['img_name'] = $postImg;

    if ($imageIsRequired && empty($data['img_name'])) {

      $errorData['error'] = true;
      $errorData['img_error'] = "Insira uma imagem";
    }

    if (!empty($data['img_files']) && !empty($data['img_name'])) {

      $imagesHandler = new ImagesHandler();

      $validatedImgRequest =
        $imagesHandler->verifySubmittedImgExtension();

      $errorData['error'] = $validatedImgRequest[0];
      $errorData['img_error'] = $validatedImgRequest[1];
    }

    return ['data' => $data, 'errorData' => $errorData];
  }
}
