</main>
<?php if (isset($totalPages) && ($totalPages) > 1) { ?>
    <!-- Pagination -->
    <nav class="d-flex justify-content-center flex-wrap p-2 mt-4">
        <ul class="pagination">

            <?php if (isset($path)) {
                $explodedPath = explode('/', $path);

                $pageId = ($explodedPath[1] == 'show') ? $page : $pageId;

                $disabled = ($pageId != 1) ? '' : 'disabled';

                echo "<li class='page-item $disabled'><span class='page-link'><a href='$BASE/$path/1'>Primeira</a></span></li>";

                echo "<li class='page-item $disabled'><span class='page-link'><a href='$BASE/$path/$prev'><</a></span></li>";

                if ($pageId <= $totalPages) {
                    $elements = 0;
                    for ($i = $pageId; $i <= $totalPages; $i++) {
                        $elements += 1;
                        if ($elements < 5) {
                            $active = ($pageId == $i) ? 'active' : '';
                            echo "<li class='page-item $active'><a href='$BASE/$path/$i'><span class='page-link'>$i</span></a></li></a></li>";
                        }
                    }
                }
                $totalDisable = ($pageId != $totalPages) ? '' : 'disabled';
            ?>
                <li class="page-item <?= $totalDisable ?>">
                    <a class="page-link" href="<?= $BASE ?>/<?= $path . '/' . $next ?>">></a>
                </li>
                <li class="page-item <?= $totalDisable ?>">
                    <span class="page-link"><a href="<?= $BASE ?>/<?= $path . '/' . $totalPages ?>">Última</a></span>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>

<!-- Footer -->
<footer class="footerSection page-footer font-small blue pt-4">
    <article style="position:relative">
        <section class="footerInfo">
            <header class="text-left" style="max-width:500px">
                <h5 class="font-swashCaps lightText f-4" style="font-size:2.5rem">Gordão a 110%</h5>
                <p class="mt-2">Somos uma lanchonete e restaurante com mais de <a href="<?= $BASE ?>/about"><span class="activeYears" class="link">vinte e três</span></a> anos de tradição. Já servimos todo tipo de refeição com nosso extenso <span class="link" id="menu">menu</span>, peça já! Te convidamos a se deliciar com nossas ofertas. Você terá a satisfação a 110% e garantia de qualidade.<br>É gordão ou nada! <a href="<?= $BASE ?>/about">Saiba mais</a></p>
            </header>
            <hr class="clearfix w-100 d-md-none pb-3" style="border-top:1px solid #d48369!important">
            <div class="footerMenus d-flex flex-wrap">
                <section class="">
                    <h5 class="text-uppercase">Menu</h5>
                    <nav class="">
                        <ul class="list-unstyled mr-4">
                            <li><a href="<?= $BASE ?>">Home</a></li>
                            <li><a href="<?= $BASE ?>/products">Ofertas</a></li>
                            <li><a href="<?= $BASE ?>/posts">Blog</a></li>
                            <li><a href="<?= $BASE ?>/gallery">Galeria</a></li>
                            <li><a href="<?= $BASE ?>/gallery">Sobre</a></li>
                        </ul>
                    </nav>
                </section>
                <section class="">
                    <h5 class="text-uppercase">Categorias</h5>
                    <nav>
                        <ul class="list-unstyled">
                            <li><a href="<?= $BASE ?>/categories/show/1">Habúrgueres</a></li>
                            <li><a href="<?= $BASE ?>/categories/show/2">Pizzas</a></li>
                            <li><a href="<?= $BASE ?>/categories/show/3">Porções</a></li>
                            <li><a href="<?= $BASE ?>/categories/show/4">Combos</a></li>
                            <li><a href="<?= $BASE ?>/categories/show/5">Bebidas</a></li>
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
        <?php if ($getQuery[0] == '' || $getQuery[0] == 'home') { ?>
            <style>@media screen and (min-width:1000px) { footer article {flex-direction: row !important;align-items: center} .footerInfo {flex-wrap: wrap !important;max-width: 436px;align-items: center}}</style>
            <section class="contactSection">
                <address data-anima="right">
                    <nav>
                        <h5 class="text-uppercase">Entre em Contato</h5>
                        <ul class="list-unstyled">
                            <li><a href="<?= $BASE ?>/contact/message">Envie sua menssagem</a></li>
                            <li><a href="<?= $BASE ?>/contact/work">Trabalhe conosco</a></li>
                            <li><i class="fa fa-map-marker fa-2x" style="color:#d22"></i>Barueri - SP</li>
                            <li><i class="fa fa-phone fa-2x" style="color:#ff9800"></i>(55) 43825357
                            </li>
                            <li><i class="fa fa-whatsapp fa-2x" style="color:#4AC959"></i>(55) 43825357</li>
                            <li class=""><i class="fa fa-envelope fa-2x"></i><a href="mailto:marcos_sco@outlook.com">gordão110%@outlook.com</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="map">
                        <h6 class="text-uppercase">Onde estamos</h6>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58537.08625555666!2d-46.91708754613075!3d-23.512068734946492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94cf03dd6cef1295%3A0x746b94a987d123a3!2sBarueri%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1591283488037!5m2!1spt-BR!2sbr" width="100%" height="220" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </address>
            </section>
        <?php } ?>
    </article>
    <adress class="copyRight d-block footer-copyright text-center py-3" style="position:relative;">© <span id="footerDate">2020</span> Desenvolvido por <a href="https://www.linkedin.com/in/marcos-dos-santos-carvalho-67a51715a/" target="_blank" style="font-weight:bolder">Marcos dos Santos Carvalho</a>
    </adress>
</footer>
<!-- Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>
<?= ($getQuery[0] == '' || $getQuery[0] == 'home') ? "<!-- Hero Slider --><script src='$BASE/public/js/heroSlider.js'></script>
<!-- Owl -->
<script src='$BASE/public/js/owl.carousel.min.js'></script>
<script src='$BASE/public/js/owlFunctions.js'></script>" : ''; ?>
<!-- App -->
<script src="<?= $BASE ?>/public/js/app.js"></script>
</body>

</html>