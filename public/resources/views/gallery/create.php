<?php 

$formActionUrl = $BASE . '/gallery/store';

?>

<header class="galleryHeader productHeader imgBackgroundArea">
    <span>
        <h1>Adicionar imagens</h1>
    </span>
</header>

<section class="formPageArea card card-body bg-light mt5">
    <header>
        <h2>Adicionar mais imagens para galeria</h2>
    </header>

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top">
        
        <div class="form-group">

            <label for="img">Envie a imagem</label>

            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $img['name'] ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <div class="form-group mt-3">
                <label for="img_title">Descrição da imagem<sup>*</sup></label>

                <input type="text" name="img_title" id="img_title" class="form-control form-control-lg <?= isset($error['img_title_error']) && $error['img_title_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['img_title'] ?? '' ?>">

                <span class="invalid-feedback">
                    <?= $error['img_title_error'] ?? '' ?>
                </span>
            </div>

            <img src="<?= $BASE ?>/public/resources/img/default/default.png" alt="default.png" title="Imagem padrão" onerror="this.onerror=null;this.src='<?=$BASE?>/public/resources/img/not_found/no_image.jpg';">
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</section>