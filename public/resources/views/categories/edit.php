<?php

$categoryId = objParamExistsOrDefault($data, 'id');
$categorySlug = objParamExistsOrDefault($data, 'slug');
$categoryName = objParamExistsOrDefault($data, 'category_name');
$categoryImg = objParamExistsOrDefault($data, 'img');

$formActionUrl = $BASE  . '/categories/update/';

?>

<header class="categoryHeader productHeader imgBackgroundArea">
    <span>
        <h2>Editar categoria</h2>
        <h1><?= $categoryName ?></h1>
    </span>
</header>

<section class="formPageArea card card-body bg-light mt5">
    <header>
        <h3><?= $categoryName ?></h3>
    </header>

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top">

        <input type="hidden" name="id" id="<?= $categoryId ?>" value="<?= $categoryId ?>" data-js="category-form">

        <div class="form-group">
            <label for="category_name">Nome da categoria<sup>*</sup></label>

            <input type="text" name="category_name" data-slug-origin id="category_name" class="form-control form-control-lg <?= isset($error['category_name_error']) && $error['category_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $categoryName ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['category_name_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="category_slug">Slug da categoria<sup>*</sup></label>

            <input type="text" name="category_slug" data-slug-receptor id="category_slug" class="form-control form-control-lg <?= isset($error['category_slug_error']) && $error['category_slug_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $categorySlug ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['category_slug_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="category_description">Descrição da categoria<sup>*</sup></label>

            <input type="text" name="category_description" id="category_description" class="form-control form-control-lg <?= isset($error['category_description_error']) && $error['category_description_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->category_description ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['category_description_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">Coloque a imagem</label>

            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $categoryImg ?? '' ?>">

            <input type="hidden" name="img" id="img" value="<?= $categoryImg ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <img src="<?= $BASE_WITH_PUBLIC ?>/<?= imgOrDefault('product_categories', $categoryImg, $categoryId) ?>" alt="<?= $categoryImg ?>" title="<?= $categoryName ?>" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';">
        </div>

        <input type="submit" class="btn btn-success" value="Salvar">
    </form>
</section>