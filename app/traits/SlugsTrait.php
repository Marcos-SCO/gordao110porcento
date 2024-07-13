<?php

namespace App\Traits;

use Core\Model;

trait SlugsTrait
{

  public static function getSlugById($table, $id, $getFields = 'slug')
  {
    $model = new Model;
    $result = $model->selectQuery($table, "WHERE id = $id", $getFields);

    return $result;
  }

  public static function verifyIfSlugExists($table, $slug, $option = false)
  {
    $model = new Model;
    $query = "WHERE slug = '{$slug}'";
    if ($option) $query .= ' ' . $option;

    $model->selectQuery($table, $query, 'slug');

    return $model->rowCount() > 0;
  }
}
