<header class="categoryHeader productHeader imgBackgroundArea">
    <span>
        <h2>Editar categoria</h2>
        <h1><?= $data->category_name ?></h1>
    </span>
</header>
<section class="formPageArea card card-body bg-light mt5">
    <header>
        <h3><?= $data->category_name ?></h3>
    </header>
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

            <img src="<?= $BASE ?>/<?= imgOrDefault('categories', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->category_name ?>" onerror="this.onerror=null;this.src='<?=$BASE?>/public/img/not_found/no_image.jpg';">
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</section>