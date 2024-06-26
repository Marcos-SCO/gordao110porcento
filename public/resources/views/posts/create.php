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

    <form action="<?=$BASE?>/posts/store" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titulo<sup>*</sup></label>
            
            <input type="text" name="title" id="title"
                class="form-control form-control-lg <?= isset($error['title_error']) && $error['title_error'] != '' ? 'is-invalid' : '' ?>"
                value="<?= $data['title'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['title_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="img">Imagem da postagem</label>
            <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $img['name'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['img_error'] ?? '' ?>
            </span>

            <img src="<?=$BASE?>/public/resources/img/default/default.png" alt="default.png" title="Imagem padrão">
        </div>

        <div class="form-group">
            <label for="body">Digite o texto: <sup>*</sup></label>
            <textarea name="body" id="tinyMCE"
                class="form-control form-control-lg <?= isset($error['body_error']) && $error['body_error'] != '' ? 'is-invalid' : '' ?>"><?= $data['body'] ?? '' ?></textarea>

            <span class="invalid-feedback">
                <?=  $error['body_error'] ?? '' ?>
            </span>
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</section>