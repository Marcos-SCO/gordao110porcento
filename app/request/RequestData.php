<?php

namespace App\Request;

class RequestData
{

  public static function getPostData()
  {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

    return $post;
  }

  public static function getRequestParams()
  {
    $post = self::getPostData();
    if (!$post) return;

    $notAllowedTags = array('<script>', '<a>');

    $body = trim(indexParamExistsOrDefault($post, 'body', ''));
    $body = str_replace($notAllowedTags, '', $body);


    $id = indexParamExistsOrDefault($post, 'id');

    $adm = indexParamExistsOrDefault($post, 'adm', 0);

    // $name = indexParamExistsOrDefault($post, 'name');

    // $lastName = indexParamExistsOrDefault($post, 'last_name');

    // $email = indexParamExistsOrDefault($post, 'email');

    $bio = indexParamExistsOrDefault($post, 'bio');

    // $password = verifyValue($post, 'password');

    // $confirmPassword =
    //   indexParamExistsOrDefault($post, 'confirm_password', '');


    $categoryName = trim(indexParamExistsOrDefault($post, 'category_name', ''));

    $categoryNameError = trim(indexParamExistsOrDefault($post, 'category_name_error', ''));

    $categoryDescription = trim(indexParamExistsOrDefault($post, 'category_description', ''));

    $categoryDescriptionError = trim(indexParamExistsOrDefault($post, 'category_description_error', ''));


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


    // $nameError = indexParamExistsOrDefault($post, 'name_error');

    // $lastNameError = indexParamExistsOrDefault($post, 'last_name_error');

    // $emailError = indexParamExistsOrDefault($post, 'email_error');

    // $passwordError = indexParamExistsOrDefault($post, 'password_error');

    // $confirmPasswordError = indexParamExistsOrDefault($post, 'confirm_password_error');

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
      'adm' => $adm,

      // 'name' => $name,
      // 'last_name' => $lastName,

      // 'email' => $email,
      // 'password' => $password,
      // 'confirm_password' => $confirmPassword,

      'bio' => $bio,

      'user_id' => $userId,
      'id_category' => $postIdCategory,

      'category_name' => $categoryName,
      'category_description' => $categoryDescription,

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
      // 'name_error' => $nameError,
      // 'last_name_error' => $lastNameError,

      // 'email_error' => $emailError,
      // 'password_error' => $passwordError,
      // 'confirm_password_error' => $confirmPasswordError,

      'id_category_error' => $postIdCategoryError,
      'title_error' => $titleError,
      'body_error' => $bodyError,

      'category_name_error' => $categoryNameError,
      'category_description_error' => $categoryDescriptionError,

      'product_name_error' => $productNameError,
      'product_description_error' => $productDescriptionError,
      'price_error' => $priceError,

      'img_title_error' => $imgGalleryTitleDescriptionError,

      'img_error' => $imgPathError,
      'error' => false
    ];

    return ['data' => $data, 'errorData' => $errors];
  }
}
