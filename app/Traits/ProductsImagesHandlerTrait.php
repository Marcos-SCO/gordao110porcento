<?php

namespace App\Traits;

trait ProductsImagesHandlerTrait
{

  public function moveUploadImageFolder($data)
  {
    $id = $data['id'];
    $productIdCategory = $data['product_id_category'];

    $currentProductCategoryId = $data['current_product_category_id'];

    $currentAndSelectedCategoriesAreEqual =
      $currentProductCategoryId == $productIdCategory;

    $result = $this->model->getProduct($id, $productIdCategory);

    $resultId = $this->model->getProductId($id);

    $imgFiles = indexParamExistsOrDefault($data, 'img_files');
    $imgName = indexParamExistsOrDefault($imgFiles, 'name');
    $tempName = indexParamExistsOrDefault($imgFiles, 'tmp_name');

    $postImg = $data['post_img'];

    if (!$result) {

      $isEmptyImg = $imgName == "";

      if ($isEmptyImg) $data['img_name'] = $postImg;

      if (!$isEmptyImg) {

        $createdFolderPath =
          $this->imagesHandler->createCategoryItemFolder('products', $id, $productIdCategory);

        $this->imagesHandler->moveUpload($createdFolderPath);

        if (!empty($imgName)) $data['img_name'] = $imgName;
        if (empty($imgName)) $data['img_name'] = $postImg;

        return $data;
      }
    }

    // Create a new path
    $fullPath = $this->imagesHandler->createCategoryItemFolder('products', $productIdCategory, $id) . $imgName;

    $this->imagesHandler->moveUpload($fullPath);

    // Get img data
    $img = (!empty($imgName)) ? $imgName : $postImg;

    if (!empty($imgName)) $data['img_name'] = $imgName;
    if (empty($imgName)) $data['img_name'] = $postImg;

    $oldFolderPath = "./../public/resources/img/products/category_{$resultId->id_category}/id_$id/$img";

    $newFolderPath =  "./../public/resources/img/products/category_{$productIdCategory}/id_$id/$img";

    $olderAdnNewPathAreEqual = $oldFolderPath == $newFolderPath;

    if (!$olderAdnNewPathAreEqual && file_exists($oldFolderPath)) {
            
      copy($oldFolderPath, $newFolderPath);

      // Delete old folder
      if (!$currentAndSelectedCategoriesAreEqual) $this->imagesHandler->deleteFolder('products', $id, $resultId->id_category);
    }

    return $data;
  }
}
