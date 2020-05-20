<div class="card card-body bg-light mt5">
    <h2>Add Post</h2>
    <p>Crie um post com esse formulário</p>
    <form action="<?=$BASE?>/gallery/store" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="img_title">Descrição da imagem<sup>*</sup></label>
            <input type="text" name="img_title" id="img_title"
                class="form-control form-control-lg <?= isset($error['img_title_error']) && $error['img_title_error'] != '' ? 'is-invalid' : '' ?>"
                value="<?= $data['img_title'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['img_title_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">Coloque a imagem</label>
            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $img['name'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</div>