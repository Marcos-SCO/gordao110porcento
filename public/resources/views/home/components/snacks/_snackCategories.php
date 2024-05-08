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

  <div class="owlDefaultItem owl-carousel owl-theme" data-js="owlDefaultItem">
    <?php foreach ($categories as $categoryItem) : 
      
      $categoryItemId = objParamExistsOrDefault($categoryItem, 'id');
      
      $categoryItemImg = objParamExistsOrDefault($categoryItem, 'img');
      
      $categoryItemName = objParamExistsOrDefault($categoryItem, 'category_name');

      ?>
      <a href="<?= $BASE ?>/categories/show/<?= $categoryItem->id ?>">
        <figure class="item"><img class="mx-auto" src="<?= $BASE ?>/<?= imgOrDefault('categories', $categoryItemImg, $categoryItem->id) ?>" alt="<?= $categoryItemImg ?>" title="<?= $categoryItemName ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';" loading="lazy" width="246" height="184">
          <figcaption><?= $categoryItemName ?></figcaption>
        </figure>
      </a>
    <?php endforeach; ?>
  </div>

</section>