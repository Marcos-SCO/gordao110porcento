<?php

$formActionUrl = $BASE . '/login';

?>

<section class="login-section-container d-flex flex-column justify-content-center align-items-center container" data-js="login-section">

    <header>
        <h1>Logar no sistema</h1>
    </header>

    <div class="col-12 col-lg-6 mx-auto">
        <div class="form-container card card-body mt-5">
            <p>Preencha os campos</p>

            <form action="<?= $formActionUrl ?>" method="post" hax-post="<?= $formActionUrl ?>" hax-target="body" hax-swap="outerHTML">

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="email" class="form-label">E-mail: <sup>*</sup></label>

                    <input type="email" name="email" id="email" class="form-control <?= isset($error['email_error']) && $error['email_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?? '' ?>">

                    <span class="invalid-feedback">
                        <?= $error['email_error'] ?? '' ?>
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