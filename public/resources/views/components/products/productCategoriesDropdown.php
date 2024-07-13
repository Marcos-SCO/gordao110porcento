<aside class="productDropdown">
  <p>Apresentar por categorias</p>

  <div class="dropdown" hx-boost="true" hx-select="main" hx-target="main" hx-swap="outerHTML show:none">

    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Selecionar</button>

    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <?php

      $currentCategoryName =
        objParamExistsOrDefault($data, 'category_name');

      echo "<li><a href='$BASE/products' class='dropdown-item'>Todas</a></li>";

      foreach ($categoryElements as $categoryItem) {

        $categoryItemSlug =
          indexParamExistsOrDefault($categoryItem, 'slug');

        $categoryItemName =
          indexParamExistsOrDefault($categoryItem, 'category_name');

        $categoryItemId =
          indexParamExistsOrDefault($categoryItem, 'id');

        $activeItem = $currentCategoryName == $categoryItemName
          ? ' active' : '';

        $categoryUrl = $BASE . '/categories/';
        if ($categoryItemSlug) $categoryUrl = $BASE . '/category/' . $categoryItemSlug;

        echo "<li><a href='$categoryUrl' class='dropdown-item$activeItem'>$categoryItemName</a></li>";
      }
      ?>
    </ul>

  </div>
</aside>