<?php

namespace App\Traits;

trait PostsImagesHandlerTrait
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
      $this->imagesHandler->imgFolderCreate('posts', $id, $imgName);

    $this->imagesHandler->moveUpload($fullPath);

    $data['img_name'] = $imgName;

    return $data;
  }
}
