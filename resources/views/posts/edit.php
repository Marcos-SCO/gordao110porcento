<div class="card card-body bg-light mt5">
    <h2><?= $data->title ?></h2>
    <form action="<?= $BASE ?>/posts/update/<?= $data->id ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" id="<?= $data->id ?>" value="<?= $data->id ?>">

        <div class="form-group">
            <label for="title">Titulo<sup>*</sup></label>
            <input type="text" name="title" id="title" class="form-control form-control-lg <?= isset($error['title_error']) && $error['title_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->title ?>">
            <span class="invalid-feedback">
                <?= $error['title_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">Imagem da postagem</label>
            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->img ?? '' ?>">
            <input type="hidden" name="img" id="img" value="<?= $data->img ?>">
            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>
            <?php if ($data->img) { ?>
                <img src="<?= $BASE ?>/public/img/posts/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->title ?>">
            <?php } ?>
        </div>

        <div class="form-group">
            <label for="body">Digite o texto: <sup>*</sup></label>
            <textarea name="body" id="tinyMCE" class="form-control form-control-lg <?= isset($error['body_error']) && $error['body_error'] != '' ? 'is-invalid' : '' ?>"><?=$data->body ?></textarea>
            <span class="invalid-feedback">
                <?= $error['body_error'] ?? '' ?>
            </span>
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</div>