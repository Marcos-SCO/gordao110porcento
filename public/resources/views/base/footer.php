<?php

// Pagination component
include_once __DIR__ . '/../components/pagination.php';

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

$controller = isset($controller) ? $controller : false;

$dataPage = isset($dataPage) ? $dataPage : mb_strtolower($controller);

$getQuery = getQueryString();

$yearsInService = date('Y') - 1997;

$isHomePage = $dataPage == 'home';
$isPostPage = $dataPage == 'posts/show';

?>

</main>

<!-- Footer -->
<footer class="footerSection page-footer font-small blue pt-4" data-base-url="<?= $BASE; ?>" data-resources-url="<?= $RESOURCES_PATH; ?>" data-page="<?= $dataPage; ?>" hx-boost="true" hx-target="body" hx-swap="outerHTML">

    <article style="position:relative">

        <section class="footerInfo">
            <header class="text-left" style="max-width:500px">
                <h5 class="font-swashCaps lightText f-4" style="font-size:2.5rem">Gordão a 110%</h5>
                <p class="mt-2">Somos uma lanchonete e restaurante com mais de <a href="<?= $BASE ?>/about">
                        <span class="activeYears" class="link"><?= $yearsInService ?></span></a> anos de tradição. Já servimos todo tipo de refeição com nosso extenso <span class="link" id="menu">menu</span>, peça já! Te convidamos a se deliciar com nossas ofertas. Você terá a satisfação a 110% e garantia de qualidade.<br>É gordão ou nada! <a href="<?= $BASE ?>/about">Saiba mais</a></p>
            </header>

            <hr class="clearfix w-100 d-md-none pb-3" style="border-top:1px solid #d48369!important">

            <div class="footerMenus d-flex flex-wrap">

                <section>
                    <h5 class="text-uppercase">Menu</h5>
                    <nav>
                        <ul class="list-unstyled mr-4">
                            <li><a href="<?= $BASE ?>">Home</a></li>
                            <li><a href="<?= $BASE ?>/products">Ofertas</a></li>
                            <li><a href="<?= $BASE ?>/posts">Blog</a></li>
                            <li><a href="<?= $BASE ?>/gallery">Galeria</a></li>
                            <li><a href="<?= $BASE ?>/gallery">Sobre</a></li>
                        </ul>
                    </nav>
                </section>

                <section>
                    <h5 class="text-uppercase">Categorias</h5>
                    <nav>
                        <ul class="list-unstyled">
                            <li><a href="<?= $BASE ?>/category/hamburgueres/">Habúrgueres</a></li>
                            <li><a href="<?= $BASE ?>/category/pizza/">Pizzas</a></li>
                            <li><a href="<?= $BASE ?>/category/porcoes/">Porções</a></li>
                            <li><a href="<?= $BASE ?>/category/combos/">Combos</a></li>
                            <li><a href="<?= $BASE ?>/category/bebidas/">Bebidas</a></li>
                        </ul>
                    </nav>
                </section>

                <address class="schedule">
                    <h5 class="text-uppercase">Horários</h5>
                    <ul class="list-unstyled">
                        <li class="lightText">Ség a Qua: 9h às 20h</li>
                        <li class="lightText">Qui e Sex: 9h às 23h</li>
                        <li class="lightText">Sab e Dom: 9h às 21h</li>
                    </ul>
                </address>

            </div>
        </section>

        <?php if ($isHomePage) :

            echo "<style>@media screen and (min-width:1000px) {footer article {flex-direction: row !important;align-items: center} .footerInfo { flex-wrap: wrap !important; max-width: 436px; align-items: center}}</style>";

        ?>

            <section class="contactSection">
                <address data-anima="right">
                    <nav>
                        <h5 class="text-uppercase">Entre em Contato</h5>
                        <ul class="list-unstyled">
                            <li><a href="<?= $BASE ?>/contact/message">Envie sua menssagem</a></li>
                            <li><a href="<?= $BASE ?>/contact/work">Trabalhe conosco</a></li>
                            <li><i class="fa fa-map-marker fa-2x" style="color:#d22"></i>Barueri - SP</li>
                            <li><i class="fa fa-phone fa-2x" style="color:#ff9800"></i>+55 11 91645-9334
                            </li>
                            <li><i class="fa fa-whatsapp fa-2x" style="color:#4AC959"></i>+55 11 91645-9334</li>
                            <li><i class="fa fa-envelope fa-2x"></i><a href="mailto:marcos_sco@outlook.com">gordão110%@outlook.com</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="map">
                        <h6 class="text-uppercase">Onde estamos</h6>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58537.08625555666!2d-46.91708754613075!3d-23.512068734946492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94cf03dd6cef1295%3A0x746b94a987d123a3!2sBarueri%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1591283488037!5m2!1spt-BR!2sbr" width="100%" height="220" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>

                </address>

            </section>
        <?php endif; ?>

    </article>

    <address class="copyRight d-block footer-copyright text-center py-3" style="position:relative;">© <span id="footerDate">2020 | <?= date('Y'); ?></span> Desenvolvido por <a href="https://www.linkedin.com/in/marcos-dos-santos-carvalho-67a51715a/" target="_blank" style="font-weight:bolder">Marcos dos Santos Carvalho</a>
    </address>
</footer>

<!-- Jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" data-js="bootstrap"></script>

<?php

$tinyMceControllers = ['posts/show', 'posts/edit'];

// $isTinyMce = in_array($dataPage, $tinyMceControllers) || strpos($requestUri, 'edit') !== false || strpos($requestUri, 'create') !== false;

// tiny MCE 

// if ($isTinyMce) echo "<!-- Tiny MCE --><script src='$RESOURCES_PATH/js/tinyMCE.js'></script>";
 
if ($isPostPage) echo '<script id="dsq-count-scr" src="//gordao110.disqus.com/count.js" async></script>';

?>

<!-- Owl min -->
<script src='<?= $RESOURCES_PATH ?>/js/libraries/owl.carousel.min.js' data-js="owl-min" defer>
    window.$.fn.owlCarousel = $.fn.owlCarousel;
</script>

<!-- Htmx -->
<script src="<?= $RESOURCES_PATH ?>/js/libraries/htmx.org@1.9.12.js"></script>

<!-- App -->
<script src="<?= $BASE_WITH_PUBLIC ?>/dist/js/index.js" type="module"></script>

</body>

</html>