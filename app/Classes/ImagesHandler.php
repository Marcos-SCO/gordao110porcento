<?php

namespace App\Classes;

use App\Request\RequestData;
use Core\Model;

class ImagesHandler
{

  public function removeDirWithFiles($dir)
  {
    foreach (glob($dir . '/*') as $itemToBeRemoved) {

      $itemIsADir = is_dir($itemToBeRemoved);

      if ($itemIsADir) $this->removeDirWithFiles($itemToBeRemoved);

      if (!$itemIsADir) unlink($itemToBeRemoved);
    }

    // remove dir
    rmdir($dir);
  }

  public function deleteFolder($table, $id, $idCategory = null, $massDel = null)
  {
    $categoryAndMassDelete = $idCategory != null && $massDel != null;

    if (!$categoryAndMassDelete) {

      // Delete imgs with id named folder
      $itemFolderPathExists =
        file_exists("../public/resources/img/{$table}/id_$id");

      if ($itemFolderPathExists) {

        array_map('unlink', glob("../public/resources/img/{$table}/id_{$id}/*.*"));

        rmdir("../public/resources/img/{$table}/id_$id");

        return;
      }
    }

    // Delete all imgs with id category and products
    if ($categoryAndMassDelete) {

      $itemCategoryFolderExists = file_exists("../public/resources/img/{$table}/category_{$idCategory}");

      if ($itemCategoryFolderExists) {

        $dir = "../public/resources/img/{$table}/category_{$idCategory}";

        $this->removeDirWithFiles($dir);
      }
    }

    if ($idCategory != null) {

      $itemFromCategoryExists = file_exists("../public/resources/img/{$table}/category_{$idCategory}/id_{$id}");

      // Delete category imgs
      if ($itemFromCategoryExists) {

        array_map('unlink', glob("../public/resources/img/{$table}/category_{$idCategory}/id_{$id}/*.*"));

        rmdir("../public/resources/img/{$table}/category_{$idCategory}/id_{$id}");
      }
    }
  }

  public function verifySubmittedImgExtension()
  {

    $imgFiles = indexParamExistsOrDefault($_FILES, 'img');

    $imgName = indexParamExistsOrDefault($imgFiles, 'name', '');

    $valid_extensions = ['jpeg', 'jpg', 'png', 'gif'];

    $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

    $error = [0 => false, 1 => false];

    if ($imgExt && !in_array($imgExt, $valid_extensions)) {

      $valid_extensions = implode(', ', $valid_extensions);

      $error = [0 => true, 1 =>  "Enviei somente {$valid_extensions} "];
    }

    return $error;
  }

  public function moveUpload($imgFullPath)
  {
    $imgFullPath = __DIR__ . '/../../' . $imgFullPath;

    $filesImg = isset($_FILES['img']) ? $_FILES['img'] : false;

    $imageTempName =
      isset($filesImg['tmp_name']) ? $filesImg['tmp_name'] : '';

    $isEmptyImg = $imageTempName == "";

    if ($isEmptyImg) {

      $dataError['error'] = true;
      $dataError['img_error'] = "Envie uma imagem";

      return $dataError;
    }

    if (!empty($imageTempName)) move_uploaded_file($imageTempName, $imgFullPath);
  }

  public function createIdItemFolder($table, $id)
  {
    if (!file_exists("../public/resources/img/{$table}/id_$id")) {

      mkdir("../public/resources/img/{$table}/id_$id");
    }

    $uploadDir = "public/resources/img/{$table}/id_$id/";

    return $uploadDir;
  }

  public function createCategoryItemFolder($table, $categoryId, $id)
  {
    if (!file_exists("../public/resources/img/{$table}/category_{$categoryId}/id_$id")) {

      mkdir("../public/resources/img/{$table}/category_{$categoryId}/id_$id", 0755, true);
    }

    $uploadDir = "public/resources/img/{$table}/category_$categoryId/id_$id/";

    return $uploadDir;
  }

  public function imgFolderCreate($table, $id, $imgName, $categoryId = null)
  {

    $emptyCategoryId = $categoryId == null;

    if ($emptyCategoryId) {

      // delete the folder
      $this->deleteFolder($table, $id);

      $uploadDir = $this->createIdItemFolder($table, $id);
    }

    if (!$emptyCategoryId) {

      $this->deleteFolder($table, $id, $categoryId);
      // Create folder

      $uploadDir = $this->createCategoryItemFolder($table, $categoryId, $id);
    }

    $picProfile = $imgName;

    $imgFullPath = $uploadDir . $picProfile;

    return $imgFullPath;
  }

  public function getNewImgDynamicPath($table, $folderName = null)
  {
    $model = new Model();

    $tableAutoIncrementId = $model->getTableAutoIncrementId($table);

    $imgFileName = $_FILES['img']['name'];

    $imgFullPath = $this->imgFolderCreate($table, $tableAutoIncrementId, $imgFileName, $folderName);

    return $imgFullPath;
  }
}
