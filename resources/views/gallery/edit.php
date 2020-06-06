<header class="galleryHeader productHeader imgBackgroundArea">
    <span>
        <h2>Editar Imagem</h2>
        <h1><?= $data->img_title ?></h1>
    </span>
</header>
<section class="formPageArea card card-body bg-light mt5">
    <header>
        <h2><?= $data->img_title ?></h2>
    </header>
    <form action="<?= $BASE ?>/gallery/update/<?= $data->id ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" id="<?= $data->id ?>" value="<?= $data->id ?>">

        <div class="form-group">
            <label for="img_title">Descrição da imagem<sup>*</sup></label>
            <input type="text" name="img_title" id="img_title" class="form-control form-control-lg <?= isset($error['img_title_error']) && $error['img_title_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->img_title ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['img_title_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">Arquivo de imagem</label>
            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->img ?? '' ?>">
            <input type="hidden" name="img" id="img" value="<?= $data->img ?>">
            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <img src="<?= $BASE ?>/<?=imgOrDefault('gallery', $data->img,$data->id)?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>">
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</section>