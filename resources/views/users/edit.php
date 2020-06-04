<header class="imgBackgroundArea usersAdmBackground">
    <span class="text-left">
        <h2>Editar perfil<h2>
        <h1><?=$data->name?><h2>
    </span>
</header>
<section class="formPageArea card card-body bg-light mt5">
    <header>
        <h3>Preencha o formulário</h3>
    </header>
    <form action="<?= $BASE ?>/users/update" method="post" enctype="multipart/form-data" class="mb-3">
        <div class="d-flex flex-wrap">
            <div class="w-100">
                <input type="hidden" name="id" value="<?= $data->id ?>">

                <?php if ($data->id == 1) { ?>
                    <input type="hidden" name="adm" id="adm" value="1">
                <?php } ?>

                <?php if ($_SESSION['adm_id'] == 1 && $data->id != 1) { ?>
                    <!-- Tipo de usuario -->
                    <div class="form-group">
                        <label for="adm">Nivel administrativo</label>
                        <select name="adm" id="adm">
                            <optgroup label="Tipo de usuário">
                                <?php
                                for ($i = 0; $i <= 1; $i++) {
                                    $selected = ($i == $data->adm) ? 'selected' : '';
                                    $type = ['Comum', 'Administrador'];
                                    echo "<option value='$i' $selected>$type[$i]</option>";
                                }
                                ?>
                            </optgroup>
                        </select>
                    </div>
                <?php } ?>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Nome: <sup>*</sup></label>
                    <input type="text" name="name" id="name" class="form-control form-control-lg <?= isset($error['name_error']) && $error['name_error']  != '' ? 'is-invalid' : '' ?>" value="<?= $data->name ?? '' ?>">
                    <span class=" invalid-feedback">
                        <?= $error['name_error'] ?? '' ?> </span>
                </div>

                <div class="form-group">
                    <label for="last_name">Sobrenome: <sup>*</sup></label>
                    <input type="text" name="last_name" id="last_name" class="form-control form-control-lg <?= isset($error['last_name_error']) && $error['last_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->last_name ?? '' ?>">
                    <span class=" invalid-feedback">
                        <?= $error['last_name_error'] ?? '' ?> </span>
                </div>

                <div class="form-group">
                    <label for="bio">Sobre: <sup>*</sup></label>
                    <textarea type="text" name="bio" id="bio" class="form-control form-control-lg"><?= $data->bio ?? '' ?></textarea>
                </div>
            </div>
            <div class="imgGroup form-group img">
                <label for="img">Imagem de perfil</label>
                <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->img ?? '' ?>">
                <input type="hidden" name="img" id="img" value="<?= $data->img ?>">
                <span class="invalid-feedback"><?= $error['img_error'] ?? '' ?></span>
                <img src="<?= $BASE ?>/<?= imgOrDefault('users', $data->img, $data->id) ?>" title="<?= $data->name ?>">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <input type="submit" value="Atualizar" class="btn btn-success btn-block">
            </div>
        </div>
    </form>
</section>