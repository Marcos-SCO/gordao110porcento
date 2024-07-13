<?php

namespace App\Request;

use App\Traits\SlugsTrait;

class SlugsRequest extends RequestData
{
  use SlugsTrait;

  public static $slugOptions = [
    'slugField' => 'slug_field',
    'slugFieldError' => 'slug_field_error'
  ];

  public static function verifyIfSlugFieldIsEmpty($slugField, $slugFieldError, $slugFieldTitle)
  {

    if (empty(self::$data[$slugField])) {
      $slugErrorTitle = 'Coloque o slug';

      if ($slugFieldTitle) $slugErrorTitle .= ' de ' . $slugFieldTitle;

      self::$errorData[$slugFieldError] = $slugErrorTitle;
    }
  }

  public static function slugExistenceValidation($table, $queryOption = false, $slugFieldTitle = false, array | bool $slugArrayParams = false)
  {
    self::$post = self::getPostData();

    if ($slugArrayParams) self::$slugOptions = $slugArrayParams;

    $slugField = indexParamExistsOrDefault(self::$slugOptions, 'slugField');

    $slugFieldError =
      indexParamExistsOrDefault(self::$slugOptions, 'slugFieldError');

    $slugInput = indexParamExistsOrDefault(self::$post, $slugField, '');

    self::$data[$slugField] = $slugInput;

    if (!empty($slugInput)) {

      self::$data[$slugField] = stringSlugFormat($slugInput);
    }

    self::verifyIfSlugFieldIsEmpty($slugField, $slugFieldError, $slugFieldTitle);

    if (!empty(self::$data[$slugField])) {

      // var_dump($queryOption);
      $slugExists = self::verifyIfSlugExists($table, self::$data[$slugField], $queryOption);

      $slugErrorTitle = 'Esse slug';

      if ($slugFieldTitle) $slugErrorTitle .= ' de ' . $slugFieldTitle;

      $slugErrorTitle .= ' já existe';
      
      if ($slugExists) self::$errorData[$slugFieldError] = $slugErrorTitle;

    }
    
    if (count(self::$errorData) > 1) self::$errorData['error'] = true;
    
    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
