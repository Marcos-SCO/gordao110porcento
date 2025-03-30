<?php

$requestUri = $_SERVER['REQUEST_URI']
    ? mb_strtolower($_SERVER['REQUEST_URI']) : '/';

$controller = isset($controller) ? $controller : false;

$dataPage = isset($dataPage) ? $dataPage : mb_strtolower($controller);

$isHomePage = $dataPage == 'home';

$isGalleryPage = $dataPage == 'gallery';

$tinyMceControllers = ['posts/edit'];

$isTinyMce = in_array($dataPage, $tinyMceControllers)
    || strpos($requestUri, 'edit') !== false
    || strpos($requestUri, 'create') !== false;

$siteName = 'Gordão a 110%';

$siteTitle = (!$isHomePage) && isset($title)
    ? $title . ' - ' . $siteName : $siteName;

$isUserLoggedIn = isLoggedIn();

$sessionUserFirstName = indexParamExistsOrDefault($_SESSION, 'user_firstName');

$sessionUserName = indexParamExistsOrDefault($_SESSION, 'username');

$sessionUserId = indexParamExistsOrDefault($_SESSION, 'user_id');

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
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $RESOURCES_PATH ?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $RESOURCES_PATH ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $RESOURCES_PATH ?>/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $RESOURCES_PATH ?>/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?= $RESOURCES_PATH ?>/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php  // Google fonts <link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps:wght@700&display=swap" rel="stylesheet">
    ?>

    <link rel="stylesheet" href="<?= $BASE_WITH_PUBLIC . '/dist/css/index.css'; ?>">

    <title><?= $siteTitle; ?></title>

</head>

<body data-page="<?= $dataPage; ?>">

    <?php // if (!$isHomePage) echo '<!-- Spinner --><div id="loader" class="center" style="display:none"></div>'; 

    // tiny MCE 
    if ($isTinyMce) echo "<!-- Tiny MCE -->
    <script src='https://cdn.tiny.cloud/1/w9vyna3bu59c6uh4z92elhfysn2dp3eob3cllbd1lktzx6r9/tinymce/5/tinymce.min.js' referrerpolicy='origin'></script><script>tinymce.init({selector:'#tinyMCE'});</script>";

    // Light Box 
    if ($isGalleryPage) echo "<!-- LightBox -->
     <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css'><script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox-plus-jquery.min.js' defer data-js='lightbox'></script>";

    ?>

    <header class="z-index bg-light main-header" id="topNav" data-js="navHeader">

        <div class="headerBody z-index" data-js="header-inner-container">
            <?php // Header nav
            include_once __DIR__ . '/../base/headerNav.php';

            ?>
        </div>

    </header>

    <?php if ($isHomePage) {

        // Hero Slider
        include_once __DIR__ . '/../components/heroSlider.php';
    }

    ?>

    <!-- To top btn -->
    <!-- <button id="topBtn" data-anima="right"><i class="fa fa-arrow-up"></i></button> -->

    <!-- WhatsApp btn -->
    <a href="<?= whatsAppMessageLink(); ?>" class="float" target="_blank" id="whats"><i class="fa fa-whatsapp my-float"></i></a>

    <main>
        <?php // Display flash messages
        displayFlashMessage();

        ?>