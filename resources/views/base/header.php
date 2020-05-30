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
    <!-- end favicon -->
    <?php
    // getQueryString
    $getQuery = getQueryString();
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
    <!-- Css -->
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/style.hero.css">
    <title><?= $title ?? 'Olá mundo!' ?></title>
</head>

<body>
    <!-- Spinner -->
    <div id="loader" class="center"></div>

    <header class="<?= ($getQuery[0] == '' || $getQuery[0] == 'home') ? 'fixed-top' : '' ?> z-index">
        <!-- Nav -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="min-height:75px;background-color:#f8f9fa;">
            <!--  Show this only on mobile to medium screens  -->
            <a class="navbar-brand d-lg-none" href="<?= $BASE ?>"><img src="http://localhost/projetosCompletos/gordao110porcento/public/img/template/gordao110_logo_300px.png" alt="gordao110_logo_300px.png" title="Grodão a 110%"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarToggle" style="padding-right: 4.4rem;">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= $BASE ?>">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE ?>/">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE ?>/posts">Postagens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $BASE ?>/gallery">Galeria</a>
                    </li>
                </ul>
                <!--   Show this only lg screens and up   -->
                <a class="navbar-brand d-none d-lg-block" style="position:absolute;top:0;margin:0!important;" href="<?= $BASE ?>"><img src="http://localhost/projetosCompletos/gordao110porcento/public/img/template/gordao110_logo_300px.png" alt="gordao110_logo_300px.png" title="Grodão a 110%"></a>

                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="<?= $BASE ?>">Sobre</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contato</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?= $BASE ?>/contact/message">Enviar Messagem</a>
                            <a class="dropdown-item" href="<?= $BASE ?>/contact/work">Trabalhe conosco</a>
                        </div>
                    </li>
                    <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['user_name'] ?? "" ?></a>
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
                    <p id="quote" style="color:#fff;">lorem</p>
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
    echo (isset($flash) && $flash != false && $flash != null) ? "<div class='" . $flash['class'] . "' id='msg-flash' style='transition: transform .18s, opacity .18s, visibility 0s .18s;position:absolute;width: 100%;text-align: center;z-index:999999999;'>" . $flash['message'] . "</div><script> /*flash message*/ let flash = document.querySelector('#msg-flash'); if (flash != null) {setTimeout(() => { flash.style = 'display:none;transition: transform .18s, opacity .18s, visibility 0s .18s;'; }, 4000); }</script>" : ''
    ?>
    <main>