<?php

namespace App\Classes;

class DynamicLinks
{

  public static function addLink($BASE, $table, $text = 'Quer adicionar mais?')
  {
    if (!$_SESSION['user_status'] == 1) return;

    echo "<a class='createBtn btn' href='$BASE/$table/create' style='width:100%;max-width:300px;display:block;margin:1rem auto;'>$text</a>";
  }

  public static function editDelete($BASE, $table, $data, $text = 'Quer Mesmo deletar?')
  {

    $userId = objParamExistsOrDefault($data, 'user_id');

    $sessionUserId = indexParamExistsOrDefault($_SESSION, 'user_id');
    $sessionAdmId = indexParamExistsOrDefault($_SESSION, 'adm_id');

    $isValidUser = ($userId == $sessionUserId) or ($sessionAdmId == 1);

    if (!$isValidUser) return;

    $verb = 'delete';

    $idCategory = '';

    $isProductTable = $table == 'products';

    $idCategory = $isProductTable
      ?  $data->id_category
      :  $data->id;

    echo "<div class='editDelete d-flex p-1 flex-wrap'>
               <a href='{$BASE}/{$table}/edit/{$data->id}' class='btn btn-warning m-1' style='height:38px'>Editar</a>

               <form action='{$BASE}/{$table}/$verb/' method='post'>

                  <input type='hidden' name='id' value='{$data->id}'>

                  <input type='hidden' name='id_category' value='{$idCategory}'>

                  <button onclick=\"return confirm('$text');\" class='btn btn-danger m-1'>Deletar</button>
               </form>

           </div>";
  }
}
