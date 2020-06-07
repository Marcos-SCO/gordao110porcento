<style>
    body {
        background-image: url('<?= $BASE ?>/public/img/template/aboutBackgroundSection.png');
        background-size: cover;
        background-attachment: fixed;
        background-repeat: no-repeat;
        background-position: top
    }
</style>
<header class="homeHeaderAbout imgBackgroundArea d-flex flex-wrap justify-content-center flex-row">
    <span>
        <img src="<?= $BASE ?>/public/img/template/gordao110_logo_300px.png"  alt="gordao110_logo.png" title="Gordão 110% logo">
        <h3 class="text-left">Sobre nós</h3>
    </span>
</header>
<article class="aboutArticle">
    <section class="about">
        <figure>
            <img src="<?= $BASE ?>/public/img/template/gordao_faxada_500.png" alt="gordao_faxada.png" title="Gordão 110% Faxada">
            <figcaption data-anima="center">
                <strong class="font-swashCaps">
                    <h1 class="lightText">Gordão a 110%</h1>
                </strong>
                <p>Somos uma lanchonete e restaurante com mais de <span id="activeYears" class="link">vinte e três</span> anos de tradição. Já servimos todo tipo de refeição com nosso extenso <span class="link" id="menu">menu</span>, peça já!. Te convidamos a se deliciar com nossas ofertas. Você terá a satisfação a 110% e garantia de qualidade. É gordão ou nada!
            </figcaption>
        </figure>
        <figure>
            <img src="<?= $BASE ?>/public/img/template/clients_500.png" alt="clients_500.png" title="Clientes" data-anima="right">
            <figcaption>
                <p><strong class="lightText">MISSÃO</strong><br>Desenvolver e comercializar lanches saudaveis, procurando sempre a inovação, ou seja criando variedades em cardapíos, agregando confiança e transparência aos nossos clientes.</p>
            </figcaption>
        </figure>
        <figure>
            <img src="<?= $BASE ?>/public/img/template/gordao_letreiros_500.png" alt="gordao_letreiros_500.png" title="Gordão Letreiros" data-anima="right">
            <figcaption>
                <p><strong class="lightText">VISÃO</strong><br>Ser a melhor lanchonete no seguimento, visando sempre o bem estar de nassos clientes. Comprometendo-se com a satisfação e valorizando nossas pessoas e visitantes.
                </p>
            </figcaption>
        </figure>
        <figure>
            <img src="<?= $BASE ?>/public/img/template/restaurante_500.png" alt="restaurante_500.png" title="Clientes" data-anima="right">
            <figcaption>
                <p><strong class="lightText">VALORES</strong><br>Trabalhando com responsabilidade, maturalidade emocional, educação cortesia e respeito, pontualidade e assuidade, com facilidade de comunicação, com entusiasmo, com segurança no que fazemos, vontade e disposição, aqui esses valores serão sempre prioridades, tornando-se um diferencial.
                </p>
            </figcaption>
        </figure>
    </section>
    <!-- Contato -->
    <section class="contactForm mb-4 m-auto pl-5 pr-5 pb-5">
        <header>
            <h2 class="h1-responsive font-weight-bold text-center my-4">Entre em contato</h2>
            <p class="text-center w-responsive mx-auto mb-5">Existe algo que você queira discutir? Então, por favor, entre em contato.</p>
        </header>
        <div class="contactRow row mb-4 align-items-center">
            <div class="col-md-9 mb-md-0 mb-5">
                <form action="<?= $BASE ?>/contact/messageSend" method="post">
                    <div class="row">
                        <div class="form-group col-md-6"> <label for="name">Nome<sup>*</sup></label> <input type="text" name="name" id="name" class="form-control form-control-lg <?= isset($error['name_error']) && $error['name_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['name'] ?? '' ?>"> <span class="invalid-feedback"> <?= $error['name_error'] ?? '' ?> </span> </div>
                        <div class="form-group col-md-6"> <label for="email">E-mail<sup>*</sup></label> <input type="text" name="email" id="email" class="form-control form-control-lg <?= isset($error['email_error']) && $error['email_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['email'] ?? '' ?>"> <span class="invalid-feedback"> <?= $error['email_error'] ?? '' ?> </span> </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12"> <label for="subject">Assunto<sup>*</sup></label> <input type="text" name="subject" id="subject" class="form-control form-control-lg <?= isset($error['subject_error']) && $error['subject_error'] != '' ? 'is-invalid' : '' ?>" value="<?= $data['subject'] ?? '' ?>"> <span class="invalid-feedback"> <?= $error['subject_error'] ?? '' ?> </span> </div>
                    </div>
                    <div class="form-group"> <label for="body">Mensagem: <sup>*</sup></label> <textarea name="body" id="body" class="form-control form-control-lg <?= isset($error['body_error']) && $error['body_error'] != '' ? 'is-invalid' : '' ?>"><?= $data['body'] ?? '' ?></textarea> <span class="invalid-feedback"> <?= $error['body_error'] ?? '' ?> </span> </div> <input type="submit" class="btn btn-success" value="Enviar" style="height:100%;width:100%;margin-bottom:1rem;">
                </form>
            </div>
            <address class="contactInfo text-center align-self-start">
                <ul class="list-unstyled">
                    <li><i class="fa fa-map-marker fa-2x" style="color:#d22"></i>
                        <p>Barueri - SP</p>
                    </li>
                    <li><i class="fa fa-phone mt-4 fa-2x" style="color:#ff9800"></i>
                        <p>(55) 43825357</p>
                    </li>
                    <li><i class="fa fa-whatsapp mt-4 fa-2x" style="color:#4AC959"></i></i>
                        <p>(55) 43825357</p>
                    </li>
                    <li class="d-flex flex-column"> <i class="fa fa-envelope mt-4 fa-2x"></i> <a href="mailto:marcos_sco@outlook.com" style="color:#333!important">gordão110%@outlook.com</a> </li>
                </ul>
            </address>
        </div>
    </section>
</article>