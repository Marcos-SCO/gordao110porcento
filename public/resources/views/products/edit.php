<?php 

$productId = objParamExistsOrDefault($data, 'id');

$productIdCategory = valueParamExistsOrDefault($product_id_category);

$productName = objParamExistsOrDefault($data, 'product_name');
$productImg = objParamExistsOrDefault($data, 'img');

$formActionUrl = $BASE  . '/products/update/';

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

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data">
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

            <input type="text" name="product_name" id="product_name" class="form-control form-control-lg <?= isset($error['product_name_error']) && $error['product_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $productName ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['product_name_error'] ?? '' ?>
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

            <input type="hidden" name="img" id="img" value="<?= $productImg ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>
            
            <img src="<?= $BASE ?>/<?= imgOrDefault('products', $productImg, $productId, "/category_$productIdCategory") ?>" title="<?= $productName ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
    </div>