<aside class="productDropdown">
  <p>Apresentar por categorias</p>

  <div class="dropdown" hx-boost="true">
    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Selecionar</button>

    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <?php

      $currentCategoryName =
        objParamExistsOrDefault($data, 'category_name');

      echo "<li><a href='$BASE/products' class='dropdown-item'>Todas</a></li>";

      foreach ($categoryElements as $categoryItem) {

        $categoryItemName =
          objParamExistsOrDefault($categoryItem, 'category_name');

        $activeItem = $currentCategoryName == $categoryItemName
          ? ' active' : '';

        echo "<li><a href='$BASE/categories/show/$categoryItem->id' class='dropdown-item$activeItem'>$categoryItemName</a></li>";
      }
      ?>
    </ul>

  </div>
</aside>