<?php
$pizzas = valueParamExistsOrDefault($pizzas);
if (!$pizzas) return;

?>
<section class="bg-light">
  <header>
    <span data-anima="left">
      <h2>Pizzas</h2>
      <p>Recheio rico e suculento</p>
    </span>
  </header>

  <div class="owlDefaultItem owl-carousel owl-theme" data-js="owlDefaultItem" modal-item-container>

    <?php foreach ($pizzas as $pizzaItem) :
      $pizzaItemId =
        objParamExistsOrDefault($pizzaItem, 'id');

      $pizzaItemIdCategory =
        objParamExistsOrDefault($pizzaItem, 'id_category');

      $pizzaItemImg =
        objParamExistsOrDefault($pizzaItem, 'img');

      $pizzaItemProductName = objParamExistsOrDefault($pizzaItem, 'product_name');

      $productDescription = objParamExistsOrDefault($pizzaItem, 'product_description');

      $pizzaItemPrice = objParamExistsOrDefault($pizzaItem, 'price');

    ?>
      <a <?= (detectIE() != true) ? 'data-toggle="modal" data-target="#itemModal"' : "href='$BASE/products/show/$pizzaItemId'" ?> id="product_<?= $pizzaItemId ?>" modal-item>
        <span style="display:none;" id="inputItens">
          <input type="hidden" name="id" value="<?= $pizzaItemId ?>">
          <input type="hidden" name="id_category" value="<?= $pizzaItemIdCategory ?>">
          <input type="hidden" name="product_name" value="<?= $pizzaItemProductName ?>">
          <input type="hidden" name="category_name" value="<?= ($pizzaItemIdCategory == 1) ? 'Hambúrgueres' : 'Pizzas' ?>">
          <input type="hidden" name="product_description" value="<?= $productDescription ?>">
          <input type="hidden" name="img" value="<?=$pizzaItemImg ?>">
          <input type="hidden" name="price" value="<?= $pizzaItemPrice ?>">
        </span>

        <figure class="item">
          <img class="mx-auto" src="<?= $BASE ?>/<?= imgOrDefault('products',$pizzaItemImg, $pizzaItemId, "/category_$pizzaItemIdCategory") ?>" alt="<?=$pizzaItemImg ?>" title="<?= $pizzaItemProductName ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';" loading="lazy" width="246" height="184">
          <figcaption><?= $pizzaItemProductName ?></figcaption>
        </figure>

      </a>
    <?php endforeach; ?>

  </div>
</section>