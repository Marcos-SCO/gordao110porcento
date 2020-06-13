<header class="contactHeader imgBackgroundArea">
    <span>
        <h2>Escreva para nós</h2>
        <h1>Envie sua menssagem</h1>
    </span>
</header>
<section class="contactForm mb-4 m-auto pl-5 pr-5 pb-5">
    <header>
        <h2 class="h1-responsive font-weight-bold text-center my-4">Entre em contato</h2>
        <p class="text-center w-responsive mx-auto mb-5">Existe algo que você queira discutir? Então, por favor, entre em contato.</p>
    </header>
    <div class="contactRow row mb-4 align-items-center">
        <div class="col-md-9 mb-md-0 mb-5">
            <form action="<?= $BASE ?>/contact/messageSend" method="post">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Nome<sup>*</sup></label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg <?= isset($error['name_error']) && $error['name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['name'] ?? '' ?>">
                        <span class="invalid-feedback">
                            <?= $error['name_error'] ?? '' ?>
                        </span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">E-mail<sup>*</sup></label>
                        <input type="text" name="email" id="email" class="form-control form-control-lg <?= isset($error['email_error']) && $error['email_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?? '' ?>">
                        <span class="invalid-feedback">
                            <?= $error['email_error'] ?? '' ?>
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="subject">Assunto<sup>*</sup></label>
                        <input type="text" name="subject" id="subject" class="form-control form-control-lg <?= isset($error['subject_error']) && $error['subject_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['subject'] ?? '' ?>">
                        <span class="invalid-feedback">
                            <?= $error['subject_error'] ?? '' ?>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="body">Mensagem: <sup>*</sup></label>
                    <textarea name="body" id="body" class="form-control form-control-lg <?= isset($error['body_error']) && $error['body_error'] != '' ? 'is-invalid' : '' ?>"><?= $data['body'] ?? '' ?></textarea>
                    <span class="invalid-feedback">
                        <?= $error['body_error'] ?? '' ?>
                    </span>
                </div>

                <input type="submit" class="btn btn-success" value="Enviar" style="height:100%;width:100%;margin-bottom:1rem;">
            </form>
        </div>
    </div>
    <address class="contactAddress m-auto">
        <h3>Onde Estamos</h3>
        <div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58537.08625555666!2d-46.91708754613075!3d-23.512068734946492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94cf03dd6cef1295%3A0x746b94a987d123a3!2sBarueri%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1591283488037!5m2!1spt-BR!2sbr" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            <ul class="list-unstyled">
                <li><i class="fa fa-map-marker fa-2x" style="color:#d22"></i>
                    <p>Barueri - SP</p>
                </li>
                <li><i class="fa fa-phone fa-2x" style="color:#ff9800"></i>
                    <p>(11) 944448798</p>
                </li>
                <li><i class="fa fa-whatsapp fa-2x" style="color:#4AC959"></i></i>
                    <p>(11) 944448798</p>
                </li>
                <li class="d-flex flex-column">
                    <i class="fa fa-envelope fa-2x"></i>
                    <a href="mailto:marcos_sco@outlook.com" style="color:#333!important">gordão110%@outlook.com</a>
                </li>
            </ul>
    </address>
</section>