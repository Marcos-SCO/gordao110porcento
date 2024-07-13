<?php

use App\Models\Category;

if (!$products) return;

$loopCount = 0;

$isSectionActiveUser =
  ($_SESSION['user_status'] && $_SESSION['user_status'] == 1);

// $categories = Category::getCategories();

foreach ($products as $data) :

  $productIdCategory = objParamExistsOrDefault($data, 'id_category');

  if (!$productIdCategory) continue;

  $loopCount += 1;

  $dataItemId = objParamExistsOrDefault($data, 'id');

  $dataItemImg = objParamExistsOrDefault($data, 'img');

  $productName = objParamExistsOrDefault($data, 'product_name');

  $categoryUrlLink = $BASE . '/categories/';

  $productDescription = objParamExistsOrDefault($data, 'product_description');
  $productPrice = objParamExistsOrDefault($data, 'price');

  $productUrlLink = $BASE . '/products/show/' . $dataItemId;

  $categoryItem = indexParamExistsOrDefault($categoryElements, $productIdCategory);

  $categoryName = indexParamExistsOrDefault($categoryItem, 'category_name');

  $categorySlug = indexParamExistsOrDefault($categoryItem, 'slug');

  $categoryUrlLink = $BASE . '/categories/';

  if ($categorySlug) $categoryUrlLink = $BASE . '/category/' . $categorySlug;

?>
  <figure class="card" data-js="loop-item">
    <a href='<?= $productUrlLink; ?>' hx-boost="true" <?= getHtmxMainTagAttributes(); ?>>
      <?php

      $imgPath = imgOrDefault('products', $dataItemImg, $dataItemId, "/category_$productIdCategory");

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

      <a href='<?= $productUrlLink; ?>' hx-boost="true" <?= getHtmxMainTagAttributes(); ?>>
        <h5 class="card-title"><?= $productName ?></h5>
      </a>

      <?php

      if ($productDescription) echo "<p class='card-text'>$productDescription</p>";

      echo '<p class="card-text">Preço: ' . $productPrice . '</p>';

      if ($categoryItem) :

      ?>
        <small class='text-muted'>
          Categoria: <a href='<?= $categoryUrlLink ?>' hx-boost='true'>
            <?= $categoryName ?>
          </a>
        </small>
      <?php endif; ?>

      <?php if ($isSectionActiveUser) : ?>
        </br>
        <a href='<?= $productUrlLink; ?>' hx-boost="true" <?= getHtmxMainTagAttributes(); ?>>Ver detalhes</a>
      <?php endif; ?>

    </figcaption>

    <?php App\Classes\DynamicLinks::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');

    ?>
  </figure>

<?php endforeach; ?>