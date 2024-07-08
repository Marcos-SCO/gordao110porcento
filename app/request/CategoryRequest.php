<?php

namespace App\Request;

class CategoryRequest extends RequestData
{

  public static function categoryFieldsValidation()
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $categoryName = indexParamExistsOrDefault($post, 'category_name');

    $categoryDescription = indexParamExistsOrDefault($post, 'category_description');

    if ($categoryName) $data['category_name'] = trim($categoryName);
    if ($categoryDescription) $data['category_description'] = trim($categoryDescription);

    if (empty($data['category_name'])) {
      $errorData['category_name_error'] = "Coloque o nome da categoria";
    }

    if (empty($data['category_description'])) {
      $errorData['category_description_error'] = "Coloque uma descrição para imagem";
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }
}
