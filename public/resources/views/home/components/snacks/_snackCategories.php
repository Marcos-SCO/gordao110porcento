<?php
$categories = valueParamExistsOrDefault($categories);

if (!$categories) return;

?>
<section class="bg-light">
  <header>
    <span data-anima="left">
      <h2>Categorias</h2>
      <p>Todas as delicias</p>
    </span>
  </header>

  <div class="owlDefaultItem owl-carousel owl-theme" data-js="owlDefaultItem" hx-boost="true" hx-target="body" hx-swap="outerHTML">
    <?php foreach ($categories as $categoryItem) :

      $categoryItemId = objParamExistsOrDefault($categoryItem, 'id');
      $categoryItemSlug = objParamExistsOrDefault($categoryItem, 'slug');

      $categoryItemImg = objParamExistsOrDefault($categoryItem, 'img');


      $categoryItemName = objParamExistsOrDefault($categoryItem, 'category_name');

      $categoryUrl = $BASE . 'categories';
      if ($categoryItemSlug) $categoryUrl = $BASE . '/category/' . $categoryItemSlug;

      $imgUrl = $BASE . '/' . imgOrDefault('product_categories', $categoryItemImg, $categoryItem->id);

    ?>
      <a href="<?= $categoryUrl ?>">

        <figure class="item">

          <img class="mx-auto" src="<?= $imgUrl ?>" alt="<?= $categoryItemImg ?>" title="<?= $categoryItemName ?>" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';" loading="lazy" width="246" height="184">

          <figcaption><?= $categoryItemName ?></figcaption>

        </figure>
      </a>
    <?php endforeach; ?>
  </div>

</section>