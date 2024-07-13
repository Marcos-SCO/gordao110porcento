<?php

namespace App\Request;

class CategoryRequest extends RequestData
{

  public static function categoryFieldsValidation()
  {
    self::$post = self::getPostData();

    $categoryName = indexParamExistsOrDefault(self::$post, 'category_name');

    $categoryDescription = indexParamExistsOrDefault(self::$post, 'category_description');

    if ($categoryName) self::$data['category_name'] = trim($categoryName);
    if ($categoryDescription) self::$data['category_description'] = trim($categoryDescription);

    if (empty(self::$data['category_name'])) {
      self::$errorData['category_name_error'] = "Coloque o nome da categoria";
    }

    if (empty(self::$data['category_description'])) {
      self::$errorData['category_description_error'] = "Coloque uma descrição para imagem";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
