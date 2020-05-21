<?= $title ?? 'Criar Post' ?>

<div class="card card-body bg-light mt5">
    <h2>Adicionar Produto</h2>
    <p>Crie um post com esse formulário</p>
    <form action="<?= $BASE ?>/products/store" method="post" enctype="multipart/form-data">

        <!-- Tipo de categoria -->
        <div class="form-group">
            <label for="id_category">Categoria</label>
            <select name="id_category" id="id_category">
                <optgroup label="Tipo de usuário">
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category->id ?>"><?= $category->category_name ?></option>
                    <?php } ?>
                </optgroup>
            </select>
            <?= $error['id_category_error'] ?? '' ?>
        </div>

        <div class="form-group">
            <label for="product_name">Nome do produto<sup>*</sup></label>
            <input type="text" name="product_name" id="product_name" class="form-control form-control-lg <?= isset($error['product_name_error']) && $error['product_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['product_name'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['product_name_error'] ?? '' ?>
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
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</div>