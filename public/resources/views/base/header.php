<?php

$controller = isset($controller) ? $controller : false;

$dataPage = isset($dataPage) ? $dataPage : mb_strtolower($controller);

$isHomeController = $controller == 'Home';

$isGalleryPage = $dataPage == 'gallery';

$tinyMceControllers = ['posts/show'];
$isTinyMce = in_array($dataPage, $tinyMceControllers);

$siteName = 'Gordão a 110%';

$siteTitle = (!$isHomeController) && isset($title)
    ? $title . ' - ' . $siteName : $siteName;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name=description content="Gordão a 110% melhor lanchonete e restaurante da região. É gordão ou nada!">
    <meta name="keywords" content="Gordão, lanchonete, Gordo, Gordão, Gordo Lanchonete, Gordão a 110%, Gordo 110%, Lanchonete Gordão, 110% lanchonete, 110% Gordão Lanchonete, lanchonete a 110%, gordao a 110%, Lanchonete a 110%">
    <meta name=author content='Marcos dos Santos Carvalho'>

    <!-- fav icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $BASE ?>/public/resources/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $BASE ?>/public/resources/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $BASE ?>/public/resources/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $BASE ?>/public/resources/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= $BASE ?>/public/resources/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <?php $getQuery = getQueryString(); // get url 
    ?>

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google fonts  -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps:wght@700&display=swap" rel="stylesheet"> -->

    <?php
    // tiny MCE 
    if ($isTinyMce) echo "<!-- Tiny MCE -->
    <script src='https://cdn.tiny.cloud/1/dksjdj5uue9ro7l3iyr2xu6basfnwgrqpkh8y5beu0m60kwl/tinymce/5/tinymce.min.js' referrerpolicy='origin'></script><script>tinymce.init({selector:'#tinyMCE'});</script>";

    // Light Box 
    if ($isGalleryPage) echo "<!-- LightBox -->
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css'><script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox-plus-jquery.min.js' defer></script>";

    ?>

    <link rel="stylesheet" href="<?= $BASE . '/public/dist/css/index.css'; ?>">

    <title><?= $siteTitle; ?></title>

</head>

<body data-page="<?= $dataPage; ?>">

    <?php // if (!$isHomeController) echo '<!-- Spinner --><div id="loader" class="center" style="display:none"></div>'; 
    ?>

    <header class="<?= $isHomeController ? 'fixed-top' : '' ?> z-index bg-light" id="topNav" data-js="navHeader">

        <!-- Nav -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:#f8f9fa;">
            <!-- Show this only on mobile to medium screens -->
            <a class="navbar-brand d-lg-none" href="<?= $BASE ?>"><img src="<?= $BASE ?>/public/resources/img/template/gordao110Logo100.png" alt="Grodão a 110%" title="Gordão a 110%"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
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
                    <li class="nav-item <?= activePage($getQuery, '') ?>"><a class="nav-link" href="<?= $BASE ?>">Home<span class="visually-hidden">(current)</span></a></li>
                    <li class="nav-item <?= ($getQuery[0] == 'products' || $getQuery[0] == 'categories') ? 'active' : '' ?>"><a class="nav-link" href="<?= $BASE ?>/products">Ofertas</a></li>
                    <li class="nav-item <?= activePage($getQuery, 'posts') ?>"><a class="nav-link" href="<?= $BASE ?>/posts">Blog</a></li>
                    <li class="nav-item <?= activePage($getQuery, 'gallery') ?>"><a class="nav-link" href="<?= $BASE ?>/gallery">Galeria</a></li>
                </ul>

                <!-- Show this only lg screens and up -->
                <a class="navbar-brand d-none d-lg-block" style="position:absolute;top:0;margin:0!important;" href="<?= $BASE ?>"><img src="<?= $BASE ?>/public/resources/img/template/gordao110Logo100.png" alt="Grodão a 110%" title="Gordão a 110%"></a>

                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link <?= activePage($getQuery, 'about') ?>" href="<?= $BASE ?>/about">Sobre</a></li>
                    <li class="nav-item dropdown <?= activePage($getQuery, 'contact') ?>">
                        <a class="nav-link dropdown-toggle" style="background:#f8f9fa!important" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contato</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="<?= $BASE ?>/contact/message">Enviar Mensagem</a></li>
                            <li><a class="dropdown-item" href="<?= $BASE ?>/contact/work">Trabalhe conosco</a></li>
                        </ul>
                    </li>

                    <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_id'])) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" style="background:#f8f9fa!important" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Adicionar</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="<?= $BASE ?>/users/create">Usuário</a></li>
                                <li><a class="dropdown-item" href="<?= $BASE ?>/categories/create">Categorias</a></li>
                                <li><a class="dropdown-item" href="<?= $BASE ?>/products/create">Produtos</a></li>
                                <li><a class="dropdown-item" href="<?= $BASE ?>/posts/create">Postagens</a></li>
                                <li><a class="dropdown-item" href="<?= $BASE ?>/gallery/create">Fotos</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown <?= activePage($getQuery, 'users') ?>">
                            <a class="nav-link dropdown-toggle" style="background:#f8f9fa!important" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $_SESSION['user_name'] ?? "" ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="<?= $BASE ?>/users/edit/<?= $_SESSION['user_id'] ?>">Meu perfil</a></li>
                                <li><a class="dropdown-item" href="<?= $BASE ?>/users/show/<?= $_SESSION['user_id'] ?>">Página</a></li>
                                <li><a class="dropdown-item" href="<?= $BASE ?>/users/">Usuários</a></li>
                                <li><a class="dropdown-item" href="<?= $BASE ?>/logout">Sair</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <!-- end nav -->

    </header>

    <?php

    if ($isHomeController) {

        // Hero Slider
        include_once __DIR__ . '/../components/heroSlider.php';
    }

    // Display flash messages
    displayFlashMessage();

    ?>

    <!-- To top btn -->
    <!-- <button id="topBtn" data-anima="right"><i class="fa fa-arrow-up"></i></button> -->

    <!-- Whatsapp btn -->
    <a href="https://api.whatsapp.com/send?phone=5511916459334&text=Olá+Marcos+tudo+bem?+Vim+por+meio+do+link+no+site+%22Gordão+a+110%%22+e+gostaria+de+conversar+com+você." class="float" target="_blank" id="whats"><i class="fa fa-whatsapp my-float"></i></a>

    <main>