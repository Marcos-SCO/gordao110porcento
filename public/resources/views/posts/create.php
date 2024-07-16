<?php

$formActionUrl = $BASE  . '/posts/store';

$title = indexParamExistsOrDefault($data, 'title');
$name = indexParamExistsOrDefault($data, 'name');
$body = indexParamExistsOrDefault($data, 'body');

$slugField = indexParamExistsOrDefault($data, 'post_slug', '');

$slugFieldError =
    indexParamExistsOrDefault($error, 'post_slug_error', '');

?>

<header class="imgBackgroundArea homeBlog">
    <span style="z-index:1">
        <h1>Criar uma postagem<h1>
    </span>
</header>

<section class="formPageArea postSection card card-body bg-light mt5">
    <header>
        <h2>Adicionar postagem</h2>
        <p>Crie uma postagem com esse formulário</p>
    </header>

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top" data-js="posts-form">

        <div class="form-group">
            <label for="title">Titulo<sup>*</sup></label>

            <input type="text" name="title" id="title" data-slug-origin class="form-control form-control-lg <?= isset($error['title_error']) && $error['title_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $title ?? '' ?>">

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

        <div class="form-group">
            <label for="img">Imagem da postagem</label>

            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $name ?? '' ?>">

            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <img src="<?= $BASE ?>/public/resources/img/default/default.png" alt="default.png" title="Imagem padrão">
        </div>

        <div class="form-group">
            <label for="body">Digite o texto: <sup>*</sup></label>

            <textarea name="body" id="tinyMCE" class="form-control form-control-lg <?= isset($error['body_error']) && $error['body_error'] != '' ? 'is-invalid' : '' ?>"><?= $body ?? '' ?></textarea>

            <span class="invalid-feedback">
                <?= $error['body_error'] ?? '' ?>
            </span>
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</section>