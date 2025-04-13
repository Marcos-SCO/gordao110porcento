<article id="article-home" hx-preserve="true">
    <div class="section">

        <section class="homeAbout">
            <header class="homeHeaderAbout imgBackgroundArea d-flex flex-wrap justify-content-center flex-row">
                <span>
                    <img src="<?= $RESOURCES_PATH ?>/img/template/gordao110_logo_300px.png" alt="gordao110_logo.png" title="Gordão 110% logo">
                    <h3 class="text-left">Sobre nós</h3>
                </span>
            </header>

            <div class="about">
                <div data-anima="center">
                    <strong class="font-swashCaps lightText">Gordão a 110%</strong>
                    <p class="mt-2">Somos uma lanchonete e restaurante com mais de <a href="<?= $BASE ?>/about"><span class="activeYears link">vinte e três</span></a> anos de tradição. Já servimos todo tipo de refeição com nosso extenso <span class="link" id="menu">menu</span>, <a href="<?= $PHONE_NUMBER_NUMBER_LINK ?>" target="_blank">peça já!.</a> Te convidamos a se deliciar com nossas ofertas. Você terá a satisfação a 110% e garantia de qualidade.<br>É gordão ou nada! <a href="<?= $BASE ?>/about">Saiba mais</a></p>
                </div>
            </div>
        </section>

        <section class="bestsSnacks imgBackgroundArea">
            <header>
                <h2>Os melhores lanches</h2>
            </header>
        </section>

        <?php
        // Snacks section
        include_once __DIR__ . '/../home/components/snacks/_snacksIndex.php';


        // Blog section posts
        include_once __DIR__ . '/../home/components/_blogSectionPosts.php';

        ?>
    </div>
</article>

<!-- Modal -->
<section class="modal fade" style="top: -1%!important;z-index:999999999;" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-js="modal-product-info">
</section>
<!-- End modal -->