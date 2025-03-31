<?php

namespace App\Traits;

trait GeneralImagesHandlerTrait
{

  public function moveUploadImageFolder($imgFolder, $data, $lastId = false)
  {

    if ($lastId) $data['id'] = $lastId;

    $id = $data['id'];

    $imgFiles = indexParamExistsOrDefault($data, 'img_files');

    $imgName = indexParamExistsOrDefault($imgFiles, 'name');

    $postImg = indexParamExistsOrDefault($data, 'post_img', '');

    $isEmptyImg = $imgName == "";

    if ($isEmptyImg) {

      $data['img_name'] = $postImg;
      return $data;
    }

    $fullPath =
      $this->imagesHandler->imgFolderCreate($imgFolder, $id, $imgName);

    $this->imagesHandler->moveUpload($fullPath);

    $data['img_name'] = $imgName;

    return $data;
  }
}
