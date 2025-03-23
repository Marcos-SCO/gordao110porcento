<?php
$hamburgers = valueParamExistsOrDefault($hamburgers, false);

if (!$hamburgers) return;

?>
<section class="bg-light">
  <header>
    <span data-anima="left">
      <h2>Hambúrgueres</h2>
      <p>Deliciosos hambúrgueres</p>
    </span>
  </header>

  <div class="owlDefaultItem owl-carousel owl-theme" data-js="owlDefaultItem" modal-item-container>

    <!-- Button trigger modal -->
    <?php foreach ($hamburgers as $hamburgerItem) :
      $hamburgerItemId =
        objParamExistsOrDefault($hamburgerItem, 'id');

      $hamburgerItemIdCategory =
        objParamExistsOrDefault($hamburgerItem, 'id_category');

      $hamburgerImg =
        objParamExistsOrDefault($hamburgerItem, 'img');

      $hamburgerProductName = objParamExistsOrDefault($hamburgerItem, 'product_name');

      $productDescription = objParamExistsOrDefault($hamburgerItem, 'product_description');

      $hamburgerPrice = objParamExistsOrDefault($hamburgerItem, 'price');

    ?>
      <a <?= (detectIE() != true) ? 'data-toggle="modal" data-target="#itemModal"' : "href='$BASE/products/show/$hamburgerItemId'" ?> id="product_<?= $hamburgerItemId ?>" modal-item>

        <span style="display:none;" id="inputItens">
          <input type="hidden" name="id" value="<?= $hamburgerItemId ?>">

          <input type="hidden" name="product_id_category" value="<?= $hamburgerItemIdCategory ?>">

          <input type="hidden" name="product_name" value="<?= $hamburgerProductName ?>">

          <input type="hidden" name="category_name" value="<?= ($hamburgerItemIdCategory == 1) ? 'Hambúrgueres' : 'Pizzas' ?>">

          <input type="hidden" name="product_description" value="<?= $productDescription ?>">

          <input type="hidden" name="img" value="<?= $hamburgerImg ?>">

          <input type="hidden" name="price" value="<?= $hamburgerPrice; ?>">
        </span>

        <figure class="item">
          <img class="mx-auto" src="<?= $BASE ?>/<?= imgOrDefault('products', $hamburgerImg, $hamburgerItemId, "/category_$hamburgerItemIdCategory") ?>" alt="<?= $hamburgerImg ?>" title="<?= $hamburgerProductName ?>" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';" loading="lazy" width="246" height="184">

          <figcaption><?= $hamburgerProductName ?></figcaption>
        </figure>

      </a>
    <?php endforeach; ?>

  </div>

</section>