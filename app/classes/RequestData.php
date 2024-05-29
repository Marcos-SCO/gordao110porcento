<?php

namespace App\Classes;

class RequestData
{

  public static function getRequestParams()
  {
    // Sanitize data
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$post) return;

    $notAllowedTags = array('<script>', '<a>');

    $body = trim(indexParamExistsOrDefault($post, 'body', ''));
    $body = str_replace($notAllowedTags, '', $body);

    $id = indexParamExistsOrDefault($post, 'id');


    $postIdCategory = indexParamExistsOrDefault($post, 'id_category');

    $title = trim(indexParamExistsOrDefault($post, 'title', ''));


    $productName = indexParamExistsOrDefault($post, 'product_name');

    $productDescription = indexParamExistsOrDefault($post, 'product_description');

    $price = verifyValue($post, 'price');

    if ($price) {

      $price = trim(preg_replace("/[^0-9,.]+/i", "", $price));
      $price = str_replace(",", ".", $price);
    }

    $imgFiles = indexParamExistsOrDefault($_FILES, 'img');

    $imgName = indexParamExistsOrDefault($imgFiles, 'name');

    $postImg = indexParamExistsOrDefault($post, 'img', '');

    $imgGalleryDescriptionTitle =
      trim(indexParamExistsOrDefault($post, 'img_title', ''));

    $imgGalleryTitleDescriptionError =
      trim(indexParamExistsOrDefault($post, 'img_title_error', ''));

    $userId = indexParamExistsOrDefault($imgFiles, 'user_id');

    $postIdCategoryError = trim(indexParamExistsOrDefault($post, 'id_category_error', ''));

    $productNameError = trim(indexParamExistsOrDefault($post, 'product_name_error', ''));

    $productDescriptionError = trim(indexParamExistsOrDefault($post, 'product_description_error', ''));

    $priceError = trim(indexParamExistsOrDefault($post, 'price_error', ''));

    $titleError =
      trim(indexParamExistsOrDefault($post, 'title_error', ''));

    $bodyError =
      trim(indexParamExistsOrDefault($post, 'body_error', ''));

    $imgPathError =
      trim(indexParamExistsOrDefault($post, 'img_error', ''));

    // Add data to array
    $data = [
      'id' => $id,
      'user_id' => $userId,
      'id_category' => $postIdCategory,
      'title' => $title,
      'body' => $body,
      'product_name' => $productName,
      'product_description' => $productDescription,
      'price' => $price,

      'img_title' => $imgGalleryDescriptionTitle,

      'img_files' => $imgFiles,
      'img_name' => $imgName,
      'post_img' => $postImg,
    ];

    $errors = [
      'id_category_error' => $postIdCategoryError,
      'title_error' => $titleError,
      'body_error' => $bodyError,

      'product_name_error' => $productNameError,
      'product_description_error' => $productDescriptionError,
      'price_error' => $priceError,

      'img_title_error' => $imgGalleryTitleDescriptionError,

      'img_error' => $imgPathError,
      'error' => false
    ];

    return ['data' => $data, 'errors' => $errors];
  }
}
