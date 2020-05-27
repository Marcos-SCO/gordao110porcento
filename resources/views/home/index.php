<article>
    <div class="section">
        <section class="background-section img-1">
            <header>
                <h2>Os melhores lanches</h2>
            </header>
        </section>
        <div>
            <section class="bg-light">
                <header>
                    <h2>Hambúrgueres</h2>
                    <p>Deliciosos hamburgueres</p>
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
                    <h2>Pizzas</h2>
                    <p>Recheio rico e suculento</p>
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
                    <h2>Categorias</h2>
                    <p>Selecione uma das categorias</p>
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
        <section class="homeAbout d-flex flex-wrap justify-content-center flex-row">
            <!-- <section class="homeAbout d-flex flex-column justify-content-center align-items-center p-2"> -->
            <div data-anima="center">
                <header>
                    <h3 class="text-left">Sobre nós</h3>
                </header>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut veritatis nulla molestiae! Facere
                    itaque ut nulla sit, dicta quibusdam quod dolorum? Excepturi neque fugit corporis tempore
                    dignissimos odit. Veniam, ipsum!
                    <a href="">Saiba mais</a>
                </p>
            </div>
        </section>
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