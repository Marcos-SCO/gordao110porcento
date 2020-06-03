<div class="card card-body bg-light mt5">
    <h2>Add Post</h2>
    <p>Crie um post com esse formulário</p>
    <form action="<?= $BASE ?>/categories/store" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category_name">Nome da categoria<sup>*</sup></label>
            <input type="text" name="category_name" id="category_name" class="form-control form-control-lg <?= isset($error['category_name_error']) && $error['category_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['category_name'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['category_name_error'] ?? '' ?>
            </span>
        </div>
        <div class="form-group">
            <label for="category_description">Descrição da categoria<sup>*</sup></label>
            <input type="text" name="category_description" id="category_description" class="form-control form-control-lg <?= isset($error['category_description_error']) && $error['category_description_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['category_description'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['category_description_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">Coloque a imagem</label>
            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $img['name'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>
            <img src="<?=$BASE?>/public/img/categories/default/default.png" alt="default.png" title="Imagem padrão">
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</div>