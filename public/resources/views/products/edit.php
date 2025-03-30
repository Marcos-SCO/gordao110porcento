<?php 

$productId = objParamExistsOrDefault($data, 'id');
$productSlug = objParamExistsOrDefault($data, 'slug');

$productIdCategory = valueParamExistsOrDefault($product_id_category);

$productName = objParamExistsOrDefault($data, 'product_name');
$productImg = objParamExistsOrDefault($data, 'img');

$formActionUrl = $BASE  . '/products/update/';

$slugFieldError =
    indexParamExistsOrDefault($error, 'product_slug_error', '');

?>

<header class="categoryHeader productHeader imgBackgroundArea">
    <span>
        <h2>Editar produto</h2>
        <h1><?= $productName ?></h1>
    </span>

    <?= ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "<small class='smallInfo'><a href='$BASE/users/show/$data->user_id'>$productName</a> adicionado em " . dateFormat($data->created_at) . "</small>" : ''; ?>
</header>

<section class="formPageArea card card-body bg-light mt5">
    <header>
        <h2><?= $productName ?></h2>
    </header>

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top" data-js="product-form">

        <input type="hidden" name="id" id="<?= $productId ?>" value="<?= $productId ?>">

        <input type="hidden" name="current_product_category_id" value="<?= $productIdCategory; ?>">

        <!-- Tipo de categoria -->
        <div class="form-group">
            <label for="product_id_category">Categoria</label>

            <select name="product_id_category" id="product_id_category">
                <optgroup label="Tipo de usuário">
                    <?php foreach ($categories as $category) {

                        $selected = ($category->id == $productIdCategory) ? 'selected' : '';

                        echo "<option value='{$category->id}' {$selected}>{$category->category_name}</option>";
                    }

                    ?>
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label for="product_name">Nome do produto<sup>*</sup></label>

            <input type="text" name="product_name" id="product_name" data-slug-origin id="product_name" class="form-control form-control-lg <?= isset($error['product_name_error']) && $error['product_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $productName ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['product_name_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="product_slug">Slug do produto<sup>*</sup></label>

            <input type="text" name="product_slug" data-slug-receptor id="product_slug" class="form-control form-control-lg <?= isset($slugFieldError) && $slugFieldError != '' ? 'is-invalid' : '' ?>" value="<?= $productSlug ?? '' ?>">

            <span class="invalid-feedback">
                <?= $slugFieldError ?? '' ?>
            </span>
        </div>
        
        <div class="form-group">
            <label for="product_description">Descrição do produto<sup>*</sup></label>

            <input type="text" name="product_description" id="product_description" class="form-control form-control-lg <?= isset($error['product_description_error']) && $error['product_description_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->product_description ?>">

            <span class="invalid-feedback">
                <?= $error['product_description_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="price">Preço<sup>*</sup></label>

            <input type="text" name="price" id="price" class="form-control form-control-lg <?= isset($error['price_error']) && $error['price_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->price ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['price_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">Coloque a imagem</label>

            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $productImg ?? '' ?>">

            <input type="hidden" name="img" value="<?= $productImg ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>
            
            <img src="<?= $BASE_WITH_PUBLIC ?>/<?= imgOrDefault('products', $productImg, $productId, "/category_$productIdCategory") ?>" title="<?= $productName ?>" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';">
        </div>

        <input type="submit" class="mt-4 btn btn-success" value="Atualizar">
    </form>
    </div>