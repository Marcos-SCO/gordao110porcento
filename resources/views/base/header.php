<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <!-- Owl css -->
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/owl.theme.default.css">
    <!-- Google fonts  -->
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps:wght@700&display=swap" rel="stylesheet">
    <!-- Css -->
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/style.css">
    <link rel="stylesheet" href="<?= $BASE ?>/public/css/style.carousel.css">
    <title><?= $title ?? 'Olá mundo!' ?></title>
</head>

<body>
    <!-- Spinner -->
    <div id="loader" class="center"></div>

    <!-- Nav -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!--  Show this only on mobile to medium screens  -->
        <a class="navbar-brand d-lg-none" href="<?= $BASE ?>">Navbar</a>

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
            <a class="navbar-brand d-none d-lg-block" style="  margin-right: 9%" href="<?= $BASE ?>">Navbar</a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $BASE ?>">Sobre</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Contato
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?= $BASE ?>/contact/message">Enviar Messagem</a>
                        <a class="dropdown-item" href="<?= $BASE ?>/contact/work">Trabalhe conosco</a>
                    </div>
                </li>
                <?php if (isset($_SESSION['user_name'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['user_name'] ?? "" ?></a>
                        <?php if (isset($SESSION_ID)) { ?>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="<?= $BASE ?>/users/edit/{{SESSION_ID}}">Meu perfil</a>
                                <a class="dropdown-item" href="<?= $BASE ?>/users/">Usuários</a>
                                <a class="dropdown-item" href="<?= $BASE ?>/categories/">Categorias</a>

                                <a class="dropdown-item" href="<?= $BASE ?>/users/logout">Sair</a>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    </li>
            </ul>
        </div>
    </nav>
    <!-- end nav -->

    <?php if (isset($carousel) && $carousel == 1) { ?>
        <!-- Header carousel -->
        <header id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <section class="carousel-inner">
                <figure class="carousel-item active">
                    <img src="<?= $BASE ?>/public/img/carousel/black_hole_on_earth-wallpaper-1920x1080.jpg" alt="..." class="img-prevent-drag">
                    <figcaption class="carousel-caption d-none d-md-block">
                        <h5>Olá</h5>
                        <p>...</p>
                    </figcaption>
                </figure>
                <figure class="carousel-item">
                    <img src="<?= $BASE ?>/public/img/carousel/black_hole_on_earth-wallpaper-1920x1080.jpg" alt="..." class="img-prevent-drag">
                    <figcaption class="carousel-caption d-none d-md-block">
                        <h5>Olá</h5>
                        <p>...</p>
                    </figcaption>
                </figure>
                <figure class="carousel-item">
                    <img src="<?= $BASE ?>/public/img/carousel/black_hole_on_earth-wallpaper-1920x1080.jpg" alt="..." class="img-prevent-drag">
                    <figcaption class="carousel-caption d-none d-md-block">
                        <h5>Olá</h5>
                        <p>...</p>
                    </figcaption>
                </figure>
            </section>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </header>
    <?php } ?>

    <?php if (isset($flash) && $flash != false && $flash != null) { ?>
        <div class="<?= $flash['class'] ?>" id='msg-flash' style="transition: transform .18s, opacity .18s, visibility 0s .18s;">
            <?= $flash['message'] ?>
        </div>
    <?php } ?>