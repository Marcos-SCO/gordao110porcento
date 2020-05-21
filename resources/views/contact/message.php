<div class="card card-body bg-light mt5">
    <h2>Entrar em contato</h2>
    <p>Envie sua menssagem</p>
    <form action="<?= $BASE ?>/contact/messageSend" method="post">
        <div class="form-group">
            <label for="name">Nome<sup>*</sup></label>
            <input type="text" name="name" id="name" class="form-control form-control-lg <?= isset($error['name_error']) && $error['name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['name'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['name_error'] ?? '' ?>
            </span>
        </div>
        <div class="form-group">
            <label for="email">E-mail<sup>*</sup></label>
            <input type="text" name="email" id="email" class="form-control form-control-lg <?= isset($error['email_error']) && $error['email_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['email_error'] ?? '' ?>
            </span>
        </div>
        <div class="form-group">
            <label for="subject">Assunto<sup>*</sup></label>
            <input type="text" name="subject" id="subject" class="form-control form-control-lg <?= isset($error['subject_error']) && $error['subject_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['subject'] ?? '' ?>">
            <span class="invalid-feedback">
                <?= $error['subject_error'] ?? '' ?>
            </span>
        </div>

        <div class="form-group">
            <label for="body">Mensagem: <sup>*</sup></label>
            <textarea name="body" id="body" class="form-control form-control-lg <?= isset($error['body_error']) && $error['subject_error'] != '' ? 'is-invalid' : '' ?>"><?= $data['body'] ?? '' ?></textarea>
            <span class="invalid-feedback">
                <?= $error['body_error'] ?? '' ?>
            </span>
        </div>

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</div>