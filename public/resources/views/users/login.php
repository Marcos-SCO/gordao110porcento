<?php

$formActionUrl = $BASE . '/login';

$data = isset($data) ? $data : false;
$error = isset($error) ? $error : false;

$userCredential = indexParamExistsOrDefault($data, 'userCredential');

$userCredentialError = indexParamExistsOrDefault($error, 'userCredential_error');

?>

<section class="login-section-container d-flex flex-column justify-content-center align-items-center container" data-js="login-section">

    <header>
        <h1>Logar no sistema</h1>
    </header>

    <div class="col-12 col-lg-6 mx-auto">
        <div class="form-container card card-body mt-5">
            <p>Preencha os campos</p>

            <form action="<?= $formActionUrl ?>" method="post" hx-post="<?= $formActionUrl ?>" hx-target="body" hx-swap="outerHTML">

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="userCredential" class="form-label">E-mail (ou usuário): <sup>*</sup></label>

                    <input type="text" name="userCredential" id="userCredential" class="form-control <?= $userCredentialError != '' ? 'is-invalid' : '' ?>" value="<?= $userCredential ?? '' ?>">

                    <span class="invalid-feedback">
                        <?= $userCredentialError ?? '' ?>
                    </span>
                </div>

                <!-- Password -->
                <div class="form-group mb-4">
                    <label for="password" class="form-label">Senha: <sup>*</sup></label>

                    <input type="password" name="password" id="password" class="form-control <?= isset($error['password_error']) && $error['password_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['password'] ?? '' ?>">

                    <span class="invalid-feedback">
                        <?= $error['password_error'] ?? '' ?>
                    </span>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="submit" value="Login" class="btn btn-success w-100 mb-3">
                    </div>
                </div>

            </form>
        </div>
    </div>

</section>