<?php

$formActionUrl = $BASE . '/users/store';

$name = indexParamExistsOrDefault($data, 'name');
$nameError = indexParamExistsOrDefault($error, 'name_error');

$lastName = indexParamExistsOrDefault($data, 'last_name');
$lastNameError = indexParamExistsOrDefault($error, 'last_name_error');

$email = indexParamExistsOrDefault($data, 'email');
$emailError = indexParamExistsOrDefault($error, 'email_error');

$password = indexParamExistsOrDefault($data, 'password');
$passwordError = indexParamExistsOrDefault($error, 'password_error');

$confirmPassword = indexParamExistsOrDefault($data, 'confirm_password');
$confirmPasswordError = indexParamExistsOrDefault($error, 'confirm_password_error');

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

            <input type="text" name="name" id="name" class="form-control form-control-lg <?= $nameError != '' ? 'is-invalid' : '' ?>" value="<?= $name ?? '' ?>">

            <span class=" invalid-feedback">
                <?= $nameError ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="last_name">Sobrenome: <sup>*</sup></label>

            <input type="text" name="last_name" id="last_name" class="form-control form-control-lg <?= $lastNameError != '' ? 'is-invalid' : '' ?>" value="<?= $lastName ?? '' ?>">

            <span class=" invalid-feedback"><?= $lastNameError ?? '' ?></span>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">E-mail: <sup>*</sup></label>

            <input name="email" id="email" class="form-control form-control-lg <?= $emailError != '' ? 'is-invalid' : '' ?>" value="<?= $email ?? '' ?>">

            <span class=" invalid-feedback"><?= $emailError ?? '' ?></span>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Senha: <sup>*</sup></label>

            <input type="password" name="password" id="password" class="form-control form-control-lg <?= $passwordError != '' ? 'is-invalid' : '' ?>" value="<?= $password ?? '' ?>">

            <span class="invalid-feedback"><?= $passwordError ?? '' ?></span>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="confirm_password">Confirmar Senha: <sup>*</sup></label>

            <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg <?= isset($confirmPasswordError) && $confirmPasswordError != '' ? 'is-invalid' : '' ?>" value="<?= $confirmPassword ?? '' ?>">

            <span class="invalid-feedback"><?= $confirmPasswordError ?? '' ?></span>
        </div>

        <div class="row">
            <div class="col">
                <input type="submit" value="Registrar" class="btn btn-success btn-block">
            </div>
        </div>

    </form>
</section>