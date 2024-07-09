<?php

namespace App\Traits;

trait UsersImagesHandlerTrait
{

  public function moveUploadImageFolder($data, $lastId = false)
  {
    if ($lastId) $data['id'] = $lastId;

    $id = $data['id'];

    $imgFiles = indexParamExistsOrDefault($data, 'img_files');

    $imgName = indexParamExistsOrDefault($imgFiles, 'name');

    $isEmptyImg = $imgName == "";

    if ($isEmptyImg) return $data;

    $fullPath =
      $this->imagesHandler->imgFolderCreate('users', $id, $imgName);

    $this->imagesHandler->moveUpload($fullPath);

    $data['img_name'] = $imgName;

    return $data;
  }
}
