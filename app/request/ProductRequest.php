<?php

namespace App\Request;

class ProductRequest extends RequestData
{

  public static function productFieldsValidation()
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $productName = indexParamExistsOrDefault($post, 'product_name');
    $productDescription = indexParamExistsOrDefault($post, 'product_description');

    $price = verifyValue($post, 'price');
    $productIdCategory = verifyValue($post, 'product_id_category');

    $currentProductCategoryId = verifyValue($post, 'current_product_category_id');

    if ($productName) $data['product_name'] = $productName;
    if ($productDescription) $data['product_description'] = $productDescription;

    // var_dump($post);
    // die();

    if ($price) {

      $price = trim(preg_replace("/[^0-9,.]+/i", "", $price));
      $price = str_replace(",", ".", $price);

      $data['price'] = $price;
    }

    if ($productIdCategory) $data['product_id_category'] = $productIdCategory;
    
    if ($currentProductCategoryId) $data['current_product_category_id'] = $currentProductCategoryId;

    if (empty($data['product_id_category'])) {
      $errorData['id_category_error'] = "Escolha a categoria";
    }

    if (empty($productName)) {
      $errorData['product_name_error'] = "Coloque o nome do produto";
    }

    if (empty($productDescription)) {
      $errorData['product_description_error'] = "Coloque a descrição do produto";
    }

    if (empty($price)) {
      $errorData['price_error'] = "Insira o preço do produto e somente valores monetários.";
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }
}
