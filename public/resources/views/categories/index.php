<?php

$linkCommonHtmlAttributes
    = 'hx-push-url="true"  
  hx-swap="show:window:top"  
  hx-target="main"  
  hx-select="main > *"';

$loopCount = 0;

?>

<header class="categoryHeader productHeader imgBackgroundArea">
    <h1>Categorias</h1>
</header>
<article class="products flex-wrap flex-column">

    <section class="products flex-wrap card-group" data-js="result-itens-container">

        <?php foreach ($categories as $data) :

            $loopCount += 1;

            $categoryShowLink =
                $BASE . '/categories/show/' . $data->id;

            $imgLoading =
                $loopCount <= 4 ? 'eager' : 'lazy';

        ?>

            <a href='<?= $categoryShowLink ?>' hx-get='<?= $categoryShowLink ?>' <?= $linkCommonHtmlAttributes; ?> data-js="loop-item">
                <figure class="card" style="color:#333!important">

                    <?php echo getImgWithAttributes(imgOrDefault('categories', $data->img, $data->id), [
                        'alt' => $data->category_name,
                        'title' => $data->category_name,
                        'width' => '299px',
                        'height' => '224px',
                        'loading' => $imgLoading
                    ]);
                    ?>

                    <figcaption class="card-body" style="height:142px;">
                        <h5 class="card-title"><?= $data->category_name ?></h5>
                        <?= "<p class='card-text'>$data->category_description</p>" ?>
                    </figcaption>
                </figure>
            </a>

        <?php endforeach; ?>

    </section>

</article>