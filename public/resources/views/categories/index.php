<?php

$linkCommonHtmlAttributes
    = 'hx-push-url="true"  
  hx-swap="show:window:top"  
  hx-target="main"  
  hx-select="main > *"';

?>

<header class="categoryHeader productHeader imgBackgroundArea">
    <h1>Categorias</h1>
</header>
<article class="products flex-wrap flex-column">

    <section class="products flex-wrap card-group" data-js="result-itens-container">

        <?php foreach ($categories as $data) :
            
            $categoryShowLink =
                $BASE . '/categories/show/' . $data->id;

        ?>

            <a href='<?= $categoryShowLink ?>' hx-get='<?= $categoryShowLink ?>' <?= $linkCommonHtmlAttributes; ?> data-js="loop-item">
                <figure class="card" style="color:#333!important">

                    <img src="<?= $BASE ?>/<?= imgOrDefault('categories', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->category_name ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">

                    <figcaption class="card-body" style="height:142px;">
                        <h5 class="card-title"><?= $data->category_name ?></h5>
                        <?= "<p class='card-text'>$data->category_description</p>" ?>
                    </figcaption>
                </figure>
            </a>

        <?php endforeach; ?>

    </section>

</article>