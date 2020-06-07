<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- fav icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $BASE ?>/public/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $BASE ?>/public/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $BASE ?>/public/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $BASE ?>/public/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= $BASE ?>/public/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?php $getQuery = getQueryString(); // get url 
    ?>
    <?php
    // tiny MCE 
    echo ($getQuery[0] == 'posts' && $getQuery[1] == 'create' || $getQuery[1] == 'edit') ? "<!-- Tiny MCE -->
    <script src='https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js' referrerpolicy='origin'></script><script>tinymce.init({selector:'#tinyMCE'});</script>" : '';
    ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Owl css -->
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/owl.theme.default.css">
    <!-- Google fonts  -->
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps:wght@700&display=swap" rel="stylesheet">
    <?php
    // Light Box 
    echo ($getQuery[0] == 'gallery') ? "<!-- LightBox -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css'><script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox-plus-jquery.min.js' defer></script>" : '';
    ?>
    <!-- Css -->
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/style.hero.css">
    <title><?= $title ?? 'Olá mundo!' ?></title>
</head>

<body>
    <header class="<?= ($getQuery[0] == '' || $getQuery[0] == 'home') ? 'fixed-top' : '' ?> z-index bg-light">
        <!-- Nav -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:#f8f9fa;">
            <!--  Show this only on mobile to medium screens  -->
            <a class="navbar-brand d-lg-none" href="<?= $BASE ?>"><img  src="http://localhost/projetosCompletos/gordao110porcento/public/img/template/gordao110_logo_300px.png" alt="gordao110_logo_300px.png" title="Grodão a 110%"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarToggle" style="padding-right: 4.4rem;">
                <?php
                function activePage($getQuery, $op)
                {
                    $active = ($getQuery[0] == $op) ? 'active' : '';
                    return $active;
                }
                ?>
                <ul class="navbar-nav">
                    <li class="nav-item <?= activePage($getQuery, '') ?>"><a class="nav-link" href="<?= $BASE ?>">Home<span class="sr-only">(current)</span></a></li>
                    <li class="nav-item <?= activePage($getQuery, 'products') ?>"><a class="nav-link" href="<?= $BASE ?>/products">Ofertas</a></li>
                    <li class="nav-item <?= activePage($getQuery, 'posts') ?>"><a class="nav-link" href="<?= $BASE ?>/posts">Blog</a></li>
                    <li class="nav-item <?= activePage($getQuery, 'gallery') ?>"><a class="nav-link" href="<?= $BASE ?>/gallery">Galeria</a></li>
                </ul>
                <!--   Show this only lg screens and up   -->
                <a class="navbar-brand d-none d-lg-block" style="position:absolute;top:0;margin:0!important;" href="<?= $BASE ?>"><img src="http://localhost/projetosCompletos/gordao110porcento/public/img/template/gordao110_logo_300px.png"  alt="gordao110_logo_300px.png" title="Grodão a 110%"></a>

                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link <?= activePage($getQuery, 'about') ?>" href="<?= $BASE ?>/about">Sobre</a></li>
                    <li class="nav-item dropdown <?= activePage($getQuery, 'contact') ?>">
                        <a class="nav-link dropdown-toggle" style="background:#f8f9fa!important" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contato</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?= $BASE ?>/contact/message">Enviar Messagem</a>
                            <a class="dropdown-item" href="<?= $BASE ?>/contact/work">Trabalhe conosco</a>
                        </div>
                    </li>
                    <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) { ?>
                        <li class="nav-item dropdown <?= activePage($getQuery, 'users') ?>">
                            <a class="nav-link dropdown-toggle" style="background:#f8f9fa!important" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['user_name'] ?? "" ?></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="<?= $BASE ?>/users/edit/<?= $_SESSION['user_id'] ?>">Meu perfil</a>
                                <a class="dropdown-item" href="<?= $BASE ?>/users/">Usuários</a>
                                <a class="dropdown-item" href="<?= $BASE ?>/categories/">Categorias</a>

                                <a class="dropdown-item" href="<?= $BASE ?>/users/logout">Sair</a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>
    <!-- end nav -->
    <?= ($getQuery[0] == 'home' || $getQuery[0] == '') ? '<!-- Hero --><div id="hero" class="hero d-flex justify-content-center align-items-center flex-column">
            <header class="p-4 d-flex flex-column justify-content-center">
                <div class="headerQuotes">
                    <h1 id="quoteTitle" class="text-left font-swashCaps" style="color:#fff;">Gordão a 110%</h1>
                    <p id="quote" style="color:#fff;">O melhor restaurante e lanchonete da região</p>
                </div>
                <a href="">Pedir agora</a>
            </header>
            <i id="prev" class="fa fa-angle-left"></i>
            <i id="next" class="fa fa-angle-right"></i>
            <ul id="heroCounter"></ul>
        </div>' : '';
    ?>

    <?php
    // Display flash messages
    echo (isset($flash) && $flash != false && $flash != null) ? "<div class='" . $flash['class'] . "' id='msg-flash' style='transition: transform .18s, opacity .18s, visibility 0s .18s;position:absolute;left:5%;top:17%;text-align: center;z-index:9999999999;'>" . $flash['message'] . "</div><script>/*flash message*/ let flash = document.querySelector('#msg-flash'); if (flash != null) {setTimeout(() => { flash.style = 'display:none;transition: transform .18s, opacity .18s, visibility 0s .18s;'; }, 4000); }</script>" : ''
    ?>
    <main><?= ($getQuery[0] !== '' && $getQuery[0] !== 'home') ? '<!-- Spinner --><div id="loader" class="center"></div>' : '' ?>
        <!-- To top btn -->
        <button id="topBtn" data-anima="right"><i class="fa fa-arrow-up"></i></button>
        <!-- Whatsapp btn -->
        <a href="https://api.whatsapp.com/send?phone=5511930268294&text=Olá+tudo+bem?+Nós+do+Gordão+a+110%,+estamos+disponíveis+aguardando+seu+contato." class="float" target="_blank" id="whats"><i class="fa fa-whatsapp my-float"></i></a>
        <script>
            //Get the button:
            let body = document.querySelector('body');
            let whats = document.querySelector('#whats');
            mybutton = document.getElementById("topBtn");
            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function() {
                scrollFunction()
            };
            // on body click don't display btn
            body.addEventListener('click', () => mybutton.style.display = 'none');

            function scrollFunction() {
                (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) ? mybutton.style = "display:block;opacity:1": mybutton.style = "display:block;opacity:0;transition:.5s";
                (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) ? whats.style = 'display:none;opacity:0;transition:.5s': whats.style = 'display:block;opacity:1;transition:.5s';
            }
            // When the user clicks on the button, scroll to the top of the document
            mybutton.addEventListener('click', function topFunction() {
                currentYOffset = self.pageYOffset;
                initYOffset = currentYOffset;
                var intervalId = setInterval(function() {
                    currentYOffset -= initYOffset * 0.05;
                    document.body.scrollTop = currentYOffset;
                    document.documentElement.scrollTop = currentYOffset;
                    document.body.scrollTop = currentYOffset; // For Chrome, Firefox, IE and Opera
                    if (self.pageYOffset == 0) {
                        clearInterval(intervalId);
                    }
                }, 30);
            });
            // Scroll to specific values
            // scrollTo is the same
            window.scroll({
                top: 2500,
                left: 0,
                behavior: 'smooth'
            });
            // Scroll certain amounts from current position 
            window.scrollBy({
                top: 100, // could be negative value
                left: 0,
                behavior: 'smooth'
            });
        </script>