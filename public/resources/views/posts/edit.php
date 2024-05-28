<header class="postEditHeader imgBackgroundArea d-flex flex-wrap justify-content-center align-items-center flex-column mb-3" style="background-image:url('<?= $BASE . '/' . imgOrDefault('posts', $data->img, $data->id) ?>');background-size:cover;background-position:top;">
    <span style="z-index:1">
        <h2><?= $data->title ?></h2>
    </span>
</header>

<section class="postSection card card-body bg-light mt5">
    <h3>Informações da postagem <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>"><?= $data->title ?></a> </h3>

    <form action="<?= $BASE ?>/posts/update/" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" id="<?= $data->id ?>" value="<?= $data->id ?>">

        <div class="form-group">
            <label for="title">Titulo<sup>*</sup></label>

            <input type="text" name="title" id="title" class="form-control form-control-lg <?= isset($error['title_error']) && $error['title_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->title ?>">

            <span class="invalid-feedback">
                <?= $error['title_error'] ?? '' ?>
            </span>
        </div>

        <div class="d-flex flex-column align-items-center form-group">
            <label for="img" class="align-self-start">Imagem da postagem <?= $data->title ?></label>

            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->img ?? '' ?>">

            <input type="hidden" name="img" id="img" value="<?= $data->img ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <img src="<?= $BASE ?>/<?= imgOrDefault('posts', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->title ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">

        </div>

        <div class="form-group">
            <label for="tinyMCE">Digite o texto: <sup>*</sup></label>

            <textarea name="body" id="tinyMCE" class="form-control form-control-lg <?= isset($error['body_error']) && $error['body_error'] != '' ? 'is-invalid' : '' ?>"><?= $data->body ?></textarea>

            <span class="invalid-feedback">
                <?= $error['body_error'] ?? '' ?>
            </span>
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</section>