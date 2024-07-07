<?php

$userId = objParamExistsOrDefault($data, 'id');

$userImg = objParamExistsOrDefault($data, 'img');

$imagePath = imgOrDefault('users', $userImg, $userId);

$userName = objParamExistsOrDefault($data, 'name');

$isAdminUser = $_SESSION['adm_id'] == 1 && $userId != 1;

$formActionUrl = $BASE  . '/users/update';

?>

<header class="imgBackgroundArea usersAdmBackground">
    <span class="text-left">
        <h2>Editar perfil</h2>
        <h1><?= $userName; ?></h1>
    </span>
</header>

<section class="formPageArea card card-body bg-light mt5">
    <header>
        <h3>Preencha o formulário</h3>
    </header>

    <form action="<?= $formActionUrl ?>" method="post" enctype="multipart/form-data" class="mb-3" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top">

        <div class="d-flex flex-wrap">
            <div class="w-100">
                <input type="hidden" name="id" value="<?= $userId ?>">

                <?php // Admin level select
                include_once __DIR__ . '/../users/components/_adminLevelSelect.php';

                ?>

                <div class="form-group">
                    <label for="name">Nome: <sup>*</sup></label>
                    <input type="text" name="name" id="name" class="form-control form-control-lg <?= isset($error['name_error']) && $error['name_error']  != '' ? 'is-invalid' : '' ?>" value="<?= $userName ?? '' ?>">
                    <span class=" invalid-feedback">
                        <?= $error['name_error'] ?? '' ?> </span>
                </div>

                <div class="form-group">
                    <label for="last_name">Sobrenome: <sup>*</sup></label>

                    <input type="text" name="last_name" id="last_name" class="form-control form-control-lg <?= isset($error['last_name_error']) && $error['last_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->last_name ?? '' ?>">

                    <span class=" invalid-feedback">
                        <?= $error['last_name_error'] ?? '' ?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="bio">Sobre: <sup>*</sup></label>

                    <textarea type="text" name="bio" id="bio" class="form-control form-control-lg"><?= $data->bio ?? '' ?></textarea>
                </div>
            </div>

            <div class="imgGroup form-group img">
                <label for="img">Imagem de perfil</label>

                <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $userImg ?>">

                <input type="hidden" name="img" value="<?= $userImg; ?>">

                <span class="invalid-feedback"><?= $error['img_error'] ?? '' ?></span>

                <img src="<?= $BASE ?>/<?= $imagePath; ?>" title="<?= $userName; ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">

            </div>
        </div>

        <div class="row">
            <div class="col">
                <input type="submit" value="Atualizar" class="btn btn-success btn-block">
            </div>
        </div>

    </form>
</section>