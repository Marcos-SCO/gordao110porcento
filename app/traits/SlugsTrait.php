<?php

namespace App\Traits;

use Core\Model;

trait SlugsTrait
{

  public static function verifyIfSlugExists($table, $slug, $option = false)
  {
    $model = new Model;
    $query = "WHERE slug = '{$slug}'";
    if ($option) $query .= ' '. $option;

    $model->selectQuery($table, $query, 'slug');

    return $model->rowCount() > 0;
  }
}
