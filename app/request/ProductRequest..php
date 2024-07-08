<?php

namespace App\Request;

class ProductRequest extends RequestData
{

  public static function productFieldsValidation()
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $price = verifyValue($post, 'price');

    if ($price) {

      $price = trim(preg_replace("/[^0-9,.]+/i", "", $price));
      $price = str_replace(",", ".", $price);
    }

    if (empty($data['product_id_category'])) {
      $errors['id_category_error'] = "Escolha a categoria";
      $errors['error'] = true;
  }

  if (empty($data['product_name'])) {
      $errors['product_name_error'] = "Coloque o nome do produto";
      $errors['error'] = true;
  }

  if (empty($data['product_description'])) {
      $errors['product_description_error'] = "Coloque a descrição do produto";
      $errors['error'] = true;
  }

  if (empty($data['price'])) {
      $errors['price_error'] = "Insira o preço do produto e somente valores monetários.";
      $errors['error'] = true;
  }

    return ['data' => $data, 'errorData' => $errorData];
  }
}
