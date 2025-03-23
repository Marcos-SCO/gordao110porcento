<?php

$formActionUrl = $BASE  . '/posts/update';

$id = objParamExistsOrDefault($data, 'id');
$slugField = objParamExistsOrDefault($data, 'slug');

$title = objParamExistsOrDefault($data, 'title');
$name = objParamExistsOrDefault($data, 'name');
$body = objParamExistsOrDefault($data, 'body');

$img = objParamExistsOrDefault($data, 'img');

$imgUrl =  $BASE . '/' .  imgOrDefault('posts', $img, $id);

$slugFieldError =
    indexParamExistsOrDefault($error, 'post_slug_error', '');

$postShowUrl = '#';
if ($slugField) $postShowUrl = $BASE . '/post/' . $slugField;

?>

<header class="postEditHeader imgBackgroundArea d-flex flex-wrap justify-content-center align-items-center flex-column mb-3" style="background-image:url('<?= $imgUrl ?>');background-size:cover;background-position:top;">
    <span style="z-index:1">
        <h2><?= $title ?></h2>
    </span>
</header>

<section class="postSection card card-body bg-light mt5">
    <h3>Informações da postagem <a href="<?= $postShowUrl ?>"><?= $title ?></a> </h3>

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top" data-js="posts-form">

        <input type="hidden" name="id" id="<?= $id ?>" value="<?= $id ?>">

        <div class="form-group">
            <label for="title">Titulo<sup>*</sup></label>

            <input type="text" name="title" id="title" data-slug-origin class="form-control form-control-lg <?= isset($error['title_error']) && $error['title_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $title ?>">

            <span class="invalid-feedback">
                <?= $error['title_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="post_slug">Slug do post<sup>*</sup></label>

            <input type="text" name="post_slug" data-slug-receptor id="post_slug" class="form-control form-control-lg <?= isset($slugFieldError) && $slugFieldError != '' ? 'is-invalid' : '' ?>" value="<?= $slugField ?? '' ?>">

            <span class="invalid-feedback">
                <?= $slugFieldError ?? '' ?>
            </span>
        </div>

        <div class="d-flex flex-column align-items-center form-group">
            <label for="img" class="align-self-start">Imagem da postagem <?= $title ?></label>

            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $img ?? '' ?>">

            <input type="hidden" name="img" id="img" value="<?= $img ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <img src="<?= $imgUrl ?>" alt="<?= $img ?>" title="<?= $title ?>" onerror="this.onerror=null;this.src='<?= $RESOURCES_PATH ?>/img/not_found/no_image.jpg';">

        </div>

        <div class="form-group">
            <label for="tinyMCE">Digite o texto: <sup>*</sup></label>

            <textarea name="body" id="tinyMCE" class="form-control form-control-lg <?= isset($error['body_error']) && $error['body_error'] != '' ? 'is-invalid' : '' ?>"><?= $body ?></textarea>

            <span class="invalid-feedback">
                <?= $error['body_error'] ?? '' ?>
            </span>
        </div>

        <input type="submit" class="btn btn-success" value="Atualizar">
    </form>
</section>