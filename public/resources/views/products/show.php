<?php

$isSectionActiveUser = isSessionActiveUser();

$productName = objParamExistsOrDefault($data, 'product_name');

$dataIdCategory = objParamExistsOrDefault($data, 'id_category');

$categoryUrlLink = $BASE . '/categories/';

$categorySlug = objParamExistsOrDefault($category, 'slug');

if ($categorySlug) $categoryUrlLink = $BASE . '/category/' . $categorySlug;

$dataCreatedAt = objParamExistsOrDefault($data, 'created_at');

$userName = objParamExistsOrDefault($user, 'name');
$userId = objParamExistsOrDefault($user, 'id');

$userUrl =  $BASE . '/users/show/' . $userId;

?>

<section class="card" style="max-width: 500px;margin:1rem auto">
    <header>
        <h1 class="text-center"><?= $productName ?></h1>
    </header>

    <figure class="productShow d-flex flex-column justify-content-center align-items-center">
        <?php echo getImgWithAttributes(imgOrDefault('products', $data->img, $data->id, "/category_$dataIdCategory"), [
            'alt' => $productName,
            'title' => $productName,
            'width' => '299px',
            'height' => '224px',
            'loading' => 'eager'
        ]);

        ?>

        <figcaption class="card-body bg-light" style="width:100%;min-height: auto!important;">
            <p>
                <?= $data->product_description ?>
                <br>Preço: <?= $data->price ?><br>

                <a href="<?= $categoryUrlLink ?>" hx-get="<?= $categoryUrlLink; ?>" <?= getHtmxMainTagAttributes(); ?> hx-swap="outerHTML">Ver Categoria</a>
                <br>

                <?php if ($isSectionActiveUser) : ?>
                    <small class='mb-3'>
                        Produto adicionado por <a href='<?= $userUrl; ?>' hx-boost="true"> <?= $userName; ?>
                        </a> em <?= $dataCreatedAt; ?>
                    </small>
                <?php endif; ?>

            </p>
        </figcaption>

        <?php if ($isSectionActiveUser) : ?>
            <div style="padding:1rem">
                <?php

                App\Classes\DynamicLinks::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');

                App\Classes\DynamicLinks::addLink($BASE, 'products', 'Adicionar mais produtos');
                ?>
            </div>
        <?php endif; ?>
    </figure>
</section>