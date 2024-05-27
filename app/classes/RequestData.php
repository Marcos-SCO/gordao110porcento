<?php

namespace App\Classes;

class RequestData
{

  public static function getPostRequestItens()
  {
    // Sanitize data
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$post) return;

    $id = indexParamExistsOrDefault($post, 'id');

    $postIdCategory = indexParamExistsOrDefault($post, 'id_category');

    $productName = indexParamExistsOrDefault($post, 'product_name');

    $productDescription = indexParamExistsOrDefault($post, 'product_description');

    $price = verifyValue($post, 'price');

    if ($price) {

      $price = trim(preg_replace("/[^0-9,.]+/i", "", $price));
      $price = str_replace(",", ".", $price);
    }

    $imgFiles = indexParamExistsOrDefault($_FILES, 'img');

    $imgName = indexParamExistsOrDefault($imgFiles, 'name');

    $postImg = isset($_POST['img']) ? $_POST['img'] : '';

    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

    $postIdCategoryError = isset($_POST['id_category_error']) ? trim($_POST['id_category_error']) : '';

    $productNameError = isset($_POST['product_name_error']) ? trim($_POST['product_name_error']) : '';

    $productDescriptionError =
      isset($_POST['product_description_error'])
      ? trim($_POST['product_description_error']) : '';

    $priceError = isset($_POST['price_error']) ? trim($_POST['price_error']) : '';

    $imgPathError = isset($_POST['img_error']) ? trim($_POST['img_error']) : '';

    // Add data to array
    $data = [
      'id' => $id,
      'id_category' => $postIdCategory,
      'product_name' => $productName,
      'product_description' => $productDescription,
      'price' => $price,
      'img_files' => $imgFiles,
      'img_name' => $imgName,
      'post_img' => $postImg,
      'user_id' => $userId,
    ];

    $errors = [
      'id_category_error' => $postIdCategoryError,
      'product_name_error' => $productNameError,
      'product_description_error' => $productDescriptionError,
      'price_error' => $priceError,
      'img_error' => $imgPathError,
      'error' => false
    ];

    return ['data' => $data, 'errors' => $error]
  }
}
