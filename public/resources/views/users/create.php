<?php

$formActionUrl = $BASE . '/users/store';

?>

<header class="imgBackgroundArea usersAdmBackground">
    <span class="text-left">
        <h1>Criar Usuário</h1>
    </span>
</header>

<section class="formPageArea card card-body bg-light mt5">

    <header>
        <h2>Crie uma Conta</h2>
        <p>Preencha o formulário</p>
    </header>

    <form action="<?= $formActionUrl ?>" method="post" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="show:body:top">

        <?php // Admin level select
        include_once __DIR__ . '/../users/components/_adminLevelSelect.php';

        ?>

        <!-- Name -->
        <div class="form-group">
            <label for="name">Nome: <sup>*</sup></label>

            <input type="text" name="name" id="name" class="form-control form-control-lg <?= isset($error['name_error']) && $error['name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['name'] ?? '' ?>">

            <span class=" invalid-feedback">
                <?= $error['name_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="last_name">Sobrenome: <sup>*</sup></label>

            <input type="text" name="last_name" id="last_name" class="form-control form-control-lg <?= isset($error['last_name_error']) && $error['last_name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['last_name'] ?? '' ?>">

            <span class=" invalid-feedback"><?= $error['last_name_error'] ?? '' ?></span>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">E-mail: <sup>*</sup></label>

            <input name="email" id="email" class="form-control form-control-lg <?= isset($error['email_error']) && $error['email_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?? '' ?>">

            <span class=" invalid-feedback"><?= $error['email_error'] ?? '' ?></span>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Senha: <sup>*</sup></label>

            <input type="password" name="password" id="password" class="form-control form-control-lg <?= isset($error['password_error']) && $error['password_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['password'] ?? '' ?>">

            <span class="invalid-feedback"><?= $error['password_error'] ?? '' ?></span>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="confirm_password">Confirmar Senha: <sup>*</sup></label>

            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg <?= isset($error['confirm_password_error']) && $error['confirm_password_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['confirm_password'] ?? '' ?>">

            <span class="invalid-feedback"><?= $error['confirm_password_error'] ?? '' ?></span>
        </div>

        <div class="row">
            <div class="col">
                <input type="submit" value="Registrar" class="btn btn-success btn-block">
            </div>
        </div>

    </form>
</section>