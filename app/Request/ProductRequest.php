<?php

namespace App\Request;

class ProductRequest extends RequestData
{

  public static function productFieldsValidation()
  {
    self::$post = self::getPostData();

    $productName = indexParamExistsOrDefault(self::$post, 'product_name');
    $productDescription = indexParamExistsOrDefault(self::$post, 'product_description');

    $price = verifyValue(self::$post, 'price');
    $productIdCategory = verifyValue(self::$post, 'product_id_category');

    $currentProductCategoryId = verifyValue(self::$post, 'current_product_category_id');

    if ($productName) self::$data['product_name'] = $productName;
    if ($productDescription) self::$data['product_description'] = $productDescription;

    if ($price) {

      $price = trim(preg_replace("/[^0-9,.]+/i", "", $price));
      $price = str_replace(",", ".", $price);

      self::$data['price'] = $price;
    }

    if ($productIdCategory) self::$data['product_id_category'] = $productIdCategory;
    
    if ($currentProductCategoryId) self::$data['current_product_category_id'] = $currentProductCategoryId;

    if (empty(self::$data['product_id_category'])) {
      self::$errorData['id_category_error'] = "Escolha a categoria";
    }

    if (empty($productName)) {
      self::$errorData['product_name_error'] = "Coloque o nome do produto";
    }

    if (empty($productDescription)) {
      self::$errorData['product_description_error'] = "Coloque a descrição do produto";
    }

    if (empty($price)) {
      self::$errorData['price_error'] = "Insira o preço do produto e somente valores monetários.";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
