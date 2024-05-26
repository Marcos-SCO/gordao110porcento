<?php

namespace App\Classes;

use Core\Model;

class Pagination
{

  public function getModel()
  {
    return new Model();
  }

  public static function handler($table, $id = 1, $limit = 5, $optionId = '', $orderOption = '')
  {
    /* Set current, prev and next page */
    $prev = ($id) - 1;
    $next = ($id) + 1;

    /* Calculate the offset */
    $offset = (($id * $limit) - $limit);

    /* Query the db for total results.*/
    if ($optionId != '') {
      list($idKey, $idVal) = $optionId;

      $key = strval($idKey);
      $val = strval($idVal);
      $optionId = " WHERE {$key} = {$val}";
    }

    $model = (new Self())->getModel();

    $totalResults = $model->customQuery("SELECT COUNT(*) AS total FROM {$table} $optionId");

    $totalPages = ceil($totalResults->total / $limit);

    $orderOption = ($orderOption != '') ? $orderOption : '';

    $orderBy = "$optionId $orderOption LIMIT $limit OFFSET $offset";
    $resultTable = $model->selectQuery($table, $orderBy);

    return ['prev' => $prev, 'next' => $next, 'totalResults' => $totalResults, 'totalPages' => $totalPages, 'tableResults' => $resultTable];
  }
}
