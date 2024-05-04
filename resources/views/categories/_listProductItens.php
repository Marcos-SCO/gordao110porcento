<?php

if (!$products) return;
if (!$categoryElements) return;

foreach ($products as $data) : ?>

  <figure class="card">
    <img src="<?= $BASE ?>/<?= imgOrDefault('products', $data->img, $data->id, "/category_$data->id_category") ?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/img/not_found/no_image.jpg';">

    <figcaption class="card-body">
      <h5 class="card-title"><?= $data->product_name ?></h5>
      <?php
      // Get category name from categories table
      foreach ($categoryElements as $element) : ($element->id == $data->id_category) ? $categoryName = $element->category_name : '';
      endforeach;

      echo "<p class='card-text'>$data->product_description</p><p class='card-text'>Preço: $data->price</p><small class='text-muted'>Categoria: <a href='$BASE/categories/show/$data->id_category'> $categoryName</a></small><br>";

      ?>
      <?= ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "<a href='$BASE/products/show/$data->id'>Ver detalhes</a>" : ''; ?>
    </figcaption>
    <?php

    Core\Controller::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');
    ?>
  </figure>

<?php endforeach; ?>