<div class="card card-body bg-light mt5">
    <h2><?= $data->category_name ?></h2>

    <form action="<?= $BASE ?>/categories/update/<?= $data->id ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" id="<?= $data->id ?>" value="<?= $data->id ?>">

        <div class="form-group">
            <label for="category_name">Nome da categoria<sup>*</sup></label>
            <input type="text" name="category_name" id="category_name" class="form-control form-control-lg <?= isset($error['category_name_error']) && $error['category_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->category_name ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['category_name_error'] ?? '' ?>
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
            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->img ?? '' ?>">
            <input type="hidden" name="img" id="img" value="<?= $data->img ?>">
            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>
            <?php if (isset($data->img)) { ?>
                <img src="<?= $BASE ?>/public/img/categories/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->category_name ?>">
            <?php } ?>
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</div>