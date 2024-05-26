<?php

declare(strict_types=1);

namespace App\Classes;

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

    if (!in_array($imgExt, $valid_extensions)) {

      $valid_extensions = implode(', ', $valid_extensions);

      $error = [0 => true, 1 =>  "Enviei somente {$valid_extensions} "];
    }

    return $error;
  }

  public function moveUpload($imgFullPath)
  {
    $imgFullPath = __DIR__ . '/../../' . $imgFullPath;

    $imageTempName = $_FILES['img']['tmp_name'];

    $isEmptyImg = $imageTempName == "";

    if ($isEmptyImg) {
      $data['img_error'] = "Envie uma imagem";
      $error = true;

      return $error;
    }

    move_uploaded_file($imageTempName, $imgFullPath);
  }

  public function imgFullPath($table, $id, $imgName, $categoryId = null)
  {

    $emptyCategoryId = $categoryId == null;

    if ($emptyCategoryId) {

      // delete the folder
      $this->deleteFolder($table, $id);

      if (!file_exists("../public/resources/img/{$table}/id_$id")) {

        mkdir("../public/resources/img/{$table}/id_$id");
      }

      $uploadDir = "public/resources/img/{$table}/id_$id/";
    }

    if (!$emptyCategoryId) {

      $this->deleteFolder($table, $id, $categoryId);
      // Create folder

      if (!file_exists("../public/resources/img/{$table}/category_{$categoryId}/id_$id")) {

        mkdir("../public/resources/img/{$table}/category_{$categoryId}/id_$id", 0755, true);
      }

      $uploadDir = "public/resources/img/{$table}/category_$categoryId/id_$id/";
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

    $imgFullPath = $this->imgFullPath($table, $tableAutoIncrementId, $imgFileName, $folderName);

    return $imgFullPath;
  }
}
