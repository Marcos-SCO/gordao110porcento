<?php

$formActionUrl = $BASE . '/gallery/update';

$id = objParamExistsOrDefault($data, 'id');
$imgTitle = objParamExistsOrDefault($data, 'img_title');

$img = objParamExistsOrDefault($data, 'img');

$imgUrlPath = $BASE . '/' . imgOrDefault('gallery', $img, $id);

?>

<header class="galleryHeader productHeader imgBackgroundArea">
    <span>
        <h2>Editar Imagem</h2>
        <h1><?= $imgTitle ?></h1>
    </span>
</header>
<section class="formPageArea card card-body bg-light mt5">

    <header>
        <h2><?= $imgTitle ?></h2>
    </header>

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top">

        <input type="hidden" name="id" id="<?= $id ?>" value="<?= $id ?>">

        <div class="form-group">

            <label for="img_title">Descrição da imagem<sup>*</sup></label>

            <input type="text" name="img_title" id="img_title" class="form-control form-control-lg <?= isset($error['img_title_error']) && $error['img_title_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $imgTitle ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['img_title_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">Arquivo de imagem</label>

            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $img ?? '' ?>">

            <input type="hidden" name="img" id="img" value="<?= $img ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <img src="<?= $imgUrlPath ?>" alt="<?= $img ?>" title="<?= $imgTitle ?>" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';">
        </div>

        <input type="submit" class="mt-4 btn btn-success" value="Atualizar">
    </form>
</section>