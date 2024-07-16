<?php

$productId = objParamExistsOrDefault($data, 'id');

$formActionUrl = $BASE . '/products/store';

$slugField = indexParamExistsOrDefault($data, 'product_slug', '');

$slugFieldError =
    indexParamExistsOrDefault($error, 'product_slug_error', '');

$productIdCategory = indexParamExistsOrDefault($data, 'product_id_category');

?>

<header class="categoryHeader productHeader imgBackgroundArea">
    <span>
        <h1>Adicionar um produto</h1>
    </span>
</header>

<section class="formPageArea card card-body bg-light mt5">
    <header>
        <h2>Adicionar Produto</h2>
    </header>

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top" data-js="product-form">

        <!-- Tipo de categoria -->
        <div class="form-group">
            <label for="product_id_category">Categoria</label>

            <select name="product_id_category" id="product_id_category" class="<?= isset($error['id_category_error']) && $error['id_category_error'] != '' ? 'is-invalid' : '' ?>">

                <optgroup label="Tipo de usuário">
                    <option value="">Selecione a categoria</option>

                    <?php foreach ($categories as $category) :
                        $selected = ($category->id == $productIdCategory) ? 'selected' : '';

                    ?>
                        <option value="<?= $category->id ?>" <?= $selected ?>><?= $category->category_name ?></option>
                    <?php endforeach; ?>
                </optgroup>
            </select>

            <span class="invalid-feedback">
                <?= $error['id_category_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">

            <label for="product_name">Nome do produto<sup>*</sup></label>

            <input type="text" name="product_name" id="product_name" data-slug-origin id="product_name" class="form-control form-control-lg <?= isset($error['product_name_error']) && $error['product_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['product_name'] ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['product_name_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="product_slug">Slug do produto<sup>*</sup></label>

            <input type="text" name="product_slug" data-slug-receptor id="product_slug" class="form-control form-control-lg <?= isset($slugFieldError) && $slugFieldError != '' ? 'is-invalid' : '' ?>" value="<?= $slugField ?? '' ?>">

            <span class="invalid-feedback">
                <?= $slugFieldError ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="product_description">Descrição do produto<sup>*</sup></label>

            <input type="text" name="product_description" id="product_description" class="form-control form-control-lg <?= isset($error['product_description_error']) && $error['product_description_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['product_description'] ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['product_description_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="price">Preço<sup>*</sup></label>

            <input type="text" name="price" id="price" class="form-control form-control-lg <?= isset($error['price_error']) && $error['price_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['price'] ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['price_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">imagem do produto</label>

            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $img->name ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <img src="<?= $BASE ?>/public/resources/img/default/default.png" title="Imagem padrão">
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>

</section>