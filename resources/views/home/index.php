<article>
    <div class="section">
        <section class="homeAbout">
            <header class="homeHeaderAbout d-flex flex-wrap justify-content-center flex-row">
                <span>
                    <img src="<?= $BASE ?>/public/img/template/gordao110_logo.png" alt="gordao110_logo.png" title="Gordão 110% logo">
                    <h3 class="text-left">Sobre nós</h3>
                </span>
            </header>
            <figure>
                <img src="<?= $BASE ?>/public/img/template/gordaoRestaurante.png" alt="gordaoRestaurante.png" title="Gordão a 110% Restaurante" data-anima="right">
                <figcaption data-anima="center">
                    <strong class="font-swashCaps">Gordão a 110%</strong>
                    <p>Somos uma lanchonete e restaurante com mais de <span id="activeYears" class="link">vinte e três</span> anos de tradição.<br>Já servimos todo tipo de refeição com nosso extenso <span class="link" id="menu">menu</span>, peça já!<br>Te convidamos a se deliciar com nossas ofertas.<br>Você terá a satisfação a 110% e garantia de qualidade.<br>É gordão ou nada! <a href="">Saiba mais</a></p>
                </figcaption>
            </figure>
            <script>
                let date = new Date();
                let activeYears = document.getElementById('activeYears');
                let year = date.getFullYear() - 1997;
                activeYears.innerText = year;
            </script>
        </section>
        <section class="background-section img-1">
            <header>
                <h2>Os melhores lanches</h2>
            </header>
        </section>
        <div class="lanches">
            <section class="bg-light">
                <header>
                    <span data-anima="left">
                        <h2>Hambúrgueres</h2>
                        <p>Deliciosos hamburgueres</p>
                    </span>
                </header>
                <div class="owl-carousel owl-theme">
                    <?php
                    foreach ($hamburguers as $h) { ?>
                        <a href="<?= $BASE ?>/products/show/<?= $h->id ?>">
                            <figure class="item">
                                <img class="mx-auto" src="<?= $BASE ?>/public/img/products/id_<?= $h->id ?>/<?= $h->img ?>" alt="<?= $h->img ?>" title="<?= $h->product_name ?>">
                                <figcaption><?= $h->product_name ?></figcaption>
                            </figure>
                        </a>
                    <?php } ?>
                </div>
            </section>
            <section class="bg-light">
                <header>
                    <span data-anima="left">
                        <h2>Pizzas</h2>
                        <p>Recheio rico e suculento</p>
                    </span>
                </header>
                <div class="owl-carousel owl-theme">
                    <?php foreach ($pizzas as $data) { ?>
                        <a href="<?= $BASE ?>/products/show/<?= $data->id ?>">
                            <figure class="item"><img class="mx-auto" src="<?= $BASE ?>/public/img/products/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>">
                                <figcaption><?= $data->product_name ?></figcaption>
                            </figure>
                        </a>
                    <?php } ?>
                </div>
            </section>
            <section class="bg-light">
                <header>
                    <span data-anima="left">
                        <h2>Categorias</h2>
                        <p>Todas as delicias</p>
                    </span>
                </header>
                <div class="owl-carousel owl-theme">
                    <?php foreach ($categories as $data) { ?>
                        <a href="<?= $BASE ?>/categories/show/<?= $data->id ?>">
                            <figure class="item"><img class="mx-auto" src="<?= $BASE ?>/public/img/categories/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->category_name ?>">
                                <figcaption><?= $data->category_name ?></figcaption>
                            </figure>
                        </a>
                    <?php } ?>
                </div>
            </section>
        </div>
        <section class="bg-light">
            <header class="m-3">
                <h2>Conheça nosso blog</h2>
                <p>Últimas noticias</p>
            </header>
            <div class="owl-carousel owl-theme">
                <?php foreach ($posts as $data) { ?>
                    <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>">
                        <figure class="item overflow-hidden img-section-max"><img class="object-fit mx-auto" src="<?= $BASE ?>/public/img/posts/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->title ?>" title="<?= $data->title ?>">
                            <figcaption class="img-fig"><?= $data->title ?></figcaption>
                        </figure>
                    </a>
                <?php } ?>
            </div>
        </section>
    </div>
</article>