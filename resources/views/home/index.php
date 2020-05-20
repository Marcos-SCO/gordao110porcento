<article>
    <section class="contaier section">
        <header class="text-center">
            <h2 class="font-swashCaps">Gordão a 110%</h2>
        </header>
        <figure class="d-flex flex-wrap flex-md-nowrap flex-row-reverse justify-content-center align-items-center">
            <img src="<?=$BASE?>/public/img/section/burger-french-fries.png" alt="" data-anima="right">
            <figcaption data-anima="center" class="p-2">
                <h3>Sobre nós</h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut veritatis nulla molestiae! Facere
                    itaque ut nulla sit, dicta quibusdam quod dolorum? Excepturi neque fugit corporis tempore
                    dignissimos odit. Veniam, ipsum!
                    <a href="">Saiba mais</a>
                </p>
            </figcaption>
        </figure>
        <section class="background-section img-1">
            <header>
                <h2>Os melhores lanches</h2>
            </header>
        </section>
        <section>
            <header>
                <h2>Hambúrgueres</h2>
            </header>
            <div class="owl-carousel owl-theme">
                <?php 
                foreach($hamburguers as $h) { ?>
                <a href="<?=$BASE?>/products/show/<?=$h->id?>">
                    <figure class="item">
                        <img class="mx-auto" src="<?=$BASE?>/public/img/products/id_<?=$h->id?>/<?=$h->img?>" alt="<?=$h->img?>" title="<?=$h->product_name?>">
                        <figcaption><?=$h->product_name?></figcaption>
                    </figure>
                </a>
                <?php } ?>
            </div>
        </section>
        <section>
            <header>
                <h2>Pizzas</h2>
            </header>
            <div class="owl-carousel owl-theme">
                <?php foreach($pizzas as $data) { ?>
                <a href="<?=$BASE?>/products/show/<?=$data->id?>">
                    <figure class="item"><img class="mx-auto"
                            src="<?=$BASE?>/public/img/products/id_<?=$data->id?>/<?=$data->img?>"
                            alt="<?=$data->img?>" title="<?=$data->product_name?>">
                        <figcaption><?=$data->product_name?></figcaption>
                    </figure>
                </a>
                <?php } ?>
            </div>
        </section>
        <section>
            <header class="m-3">
                <h2>Conheça nosso blog</h2>
                <p>Últimas noticias</p>
            </header>
            <div class="owl-carousel owl-theme">
                <?php foreach($posts as $data) { ?>
                <a href="<?=$BASE?>/posts/show/<?=$data->id?>">
                    <figure class="item overflow-hidden img-section-max"><img class="object-fit mx-auto"
                            src="<?=$BASE?>/public/img/posts/id_<?=$data->id?>/<?=$data->img?>"
                            alt="<?=$data->title?>" title="<?=$data->title?>">
                        <figcaption class="img-fig"><?=$data->title?></figcaption>
                    </figure>
                </a>
                <?php } ?>
            </div>
        </section>
    </section>
</article>