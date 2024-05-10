<?php

namespace Helpers\Classes;

class DynamicLinks
{

  public static function addLink($BASE, $table, $text = 'Quer adicionar mais?')
  {
    if (!$_SESSION['user_status'] == 1) return;

    echo "<a class='createBtn btn' href='$BASE/$table/create' style='width:100%;max-width:300px;display:block;margin:1rem auto;'>$text</a>";
  }

  public static function editDelete($BASE, $table, $data, $text = 'Quer Mesmo deletar?')
  {
    if (($data->user_id == $_SESSION['user_id']) or ($_SESSION['adm_id'] == 1)) {
      $verb = ($table == 'categories') ? 'destroy' : 'delete';

      $idCategory = '';

      $isProductTable = $table == 'products';

      $idCategory = $isProductTable
        ?  '/' . $data->id_category
        : '/' . $data->id;

      return "<div class='editDelete d-flex p-1 flex-wrap'>
               <a href='{$BASE}/{$table}/edit/{$data->id}' class='btn btn-warning m-1' style='height:38px'>Editar</a>
               <form action='{$BASE}/{$table}/$verb/{$data->id}{$idCategory}' method='post'>
                   <button onclick='return confirm('$text')' class='btn btn-danger m-1'>Deletar</button>
               </form>
           </div>";
    }
  }
}
