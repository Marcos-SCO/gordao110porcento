<?php

$loopCount = 0;

$categoryBase = $BASE . '/category/';

?>

<header class="categoryHeader productHeader imgBackgroundArea">
    <h1>Categorias</h1>
</header>
<article class="products flex-wrap flex-column">

    <section class="products flex-wrap card-group" data-js="result-itens-container">

        <?php foreach ($categories as $data) :

            $loopCount += 1;

            $dataItemId = objParamExistsOrDefault($data, 'id');

            if (!$dataItemId) continue;

            $dataItemSlug = objParamExistsOrDefault($data, 'slug');

            $dataItemImg = objParamExistsOrDefault($data, 'img');

            $categoryShowLink = $categoryBase . $dataItemSlug;

            $imgLoading =
                $loopCount <= 4 ? 'eager' : 'lazy';

            $categoryName = objParamExistsOrDefault($data, 'category_name');

            $categoryDescription =
                objParamExistsOrDefault($data, 'category_description');

            $categoryDescription =
                limitChars(objParamExistsOrDefault($data, 'category_description', ''), 90, '...');

        ?>
            <a href='<?= $categoryShowLink ?>' hx-get='<?= $categoryShowLink ?>' <?= getHtmxMainTagAttributes(); ?> data-js="loop-item">
                <figure class="card" style="color:#333!important">

                    <?php echo getImgWithAttributes(imgOrDefault('product_categories', $dataItemImg, $dataItemId), [
                        'alt' => $categoryName,
                        'title' => $categoryName,
                        'width' => '299px',
                        'height' => '224px',
                        'loading' => $imgLoading
                    ]);
                    ?>

                    <figcaption class="card-body" style="min-height:150px;">
                        <h5 class="card-title" style="min-height: 30px"><?= $categoryName ?></h5>
                        <?= "<p class='card-text'>$categoryDescription</p>" ?>
                    </figcaption>
                </figure>
            </a>

        <?php endforeach; ?>

    </section>

</article>