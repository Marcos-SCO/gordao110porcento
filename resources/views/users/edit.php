<h1><?= $title ?? 'Editar usuário' ?></h1>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt5">

            <p>Preencha o formulário</p>

            <form action="<?= $BASE ?>/users/update" method="post" enctype="multipart/form-data">

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

                <div class="form-group">
                    <label for="img">Imagem de perfil</label>
                    <input type="file" name="img" id="img" class="form-control form-control-lg <?= isset($error['img_error']) && $error['img_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data->img ?? '' ?>">
                    <input type="hidden" name="img" id="img" value="<?= $data->img ?>">
                    <span class="invalid-feedback">
                        <?= $error['img_error'] ?? '' ?>
                    </span>
                    <?php if ($data->img) { ?>
                        <img src="<?= $BASE ?>/public/img/users/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->name ?>">
                    <?php } ?>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="submit" value="Atualizar" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>