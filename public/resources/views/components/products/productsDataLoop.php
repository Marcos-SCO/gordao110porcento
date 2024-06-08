<?php

if (!$products) return;

$loopCount = 0;

$isSectionActiveUser =
  ($_SESSION['user_status'] && $_SESSION['user_status'] == 1);

foreach ($products as $data) :

  $dataIdCategory = objParamExistsOrDefault($data, 'id_category');

  if (!$dataIdCategory) continue;

  $loopCount += 1;

  $dataItemId = objParamExistsOrDefault($data, 'id');

  $dataItemImg = objParamExistsOrDefault($data, 'img');

  $productName = objParamExistsOrDefault($data, 'product_name');

  $categoryUrlLink = $BASE . '/categories/show/' . $dataIdCategory;

  $productDescription = objParamExistsOrDefault($data, 'product_description');
  $productPrice = objParamExistsOrDefault($data, 'price');

  $productUrlLink = $BASE . '/products/show/' . $dataItemId;

?>
  <figure class="card" data-js="loop-item">
    <a href='<?= $productUrlLink; ?>' hx-boost="true">
      <?php

      $imgPath = imgOrDefault('products', $dataItemImg, $dataItemId, "/category_$dataIdCategory");

      $imgLoading =
        $loopCount <= 4 ? 'eager' : 'lazy';

      echo getImgWithAttributes($imgPath, [
        'alt' => $productName,
        'title' => $productName,
        'width' => '299px',
        'height' => '224px',
        'loading' => $imgLoading
      ]);

      ?>
    </a>

    <figcaption class="card-body">

      <a href='<?= $productUrlLink; ?>' hx-boost="true">
        <h5 class="card-title"><?= $productName ?></h5>
      </a>

      <?php

      if ($categoryElements) :
        // Get category name from categories table
        foreach ($categoryElements as $element) {

          if ($element->id == $dataIdCategory) {

            $categoryName = $element->category_name;
            break;
          }
        }

        if ($productDescription) echo "<p class='card-text'>$productDescription</p>";

      ?>
        <p class='card-text'>Preço: <?= $productPrice ?></p>

        <small class='text-muted'>
          Categoria: <a href='<?= $categoryUrlLink ?>' hx-boost='<?= $categoryUrlLink ?>'>
            <?= $categoryName ?>
          </a>
        </small>
      <?php endif; ?>

      <?php if ($isSectionActiveUser) : ?>
        </br>
        <a href='<?= $productUrlLink; ?>' hx-boost="true">Ver detalhes</a>
      <?php endif; ?>

    </figcaption>

    <?php App\Classes\DynamicLinks::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');

    ?>
  </figure>

<?php endforeach; ?>