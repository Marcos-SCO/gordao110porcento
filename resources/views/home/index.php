<article>
    <div class="section">
        <section class="homeAbout">
            <header class="homeHeaderAbout imgBackgroundArea d-flex flex-wrap justify-content-center flex-row">
                <span>
                    <img src="<?= $BASE ?>/public/img/template/gordao110_logo_300px.png" class="img-prevent-drag" alt="gordao110_logo.png" title="Gordão 110% logo">
                    <h3 class="text-left">Sobre nós</h3>
                </span>
            </header>
            <div class="about">
                <div data-anima="center">
                    <strong class="font-swashCaps">Gordão a 110%</strong>
                    <p>Somos uma lanchonete e restaurante com mais de <span id="activeYears" class="link">vinte e três</span> anos de tradição.<br>Já servimos todo tipo de refeição com nosso extenso <span class="link" id="menu">menu</span>, peça já!<br>Te convidamos a se deliciar com nossas ofertas.<br>Você terá a satisfação a 110% e garantia de qualidade.<br>É gordão ou nada! <a href="">Saiba mais</a></p>
                </div>
            </div>
        </section>
        <section class="bestsSnacks imgBackgroundArea">
            <header>
                <h2>Os melhores lanches</h2>
            </header>
        </section>
        <div class="snacks">
            <section class="bg-light">
                <header>
                    <span data-anima="left">
                        <h2>Hambúrgueres</h2>
                        <p>Deliciosos hamburgueres</p>
                    </span>
                </header>
                <div class="owl-carousel owl-theme">
                    <!-- Button trigger modal -->
                    <?php
                    foreach ($hamburguers as $h) { ?>
                        <a data-toggle="modal" data-target="#itemModal" id="product_<?= $h->id ?>" onclick="callItem(this)">
                            <span style="display:none;" id="inputItens">
                                <input type="hidden" name="id" value="<?= $h->id ?>">
                                <input type="hidden" name="id_category" value="<?= $h->id_category ?>">
                                <input type="hidden" name="product_name" value="<?= $h->product_name ?>">
                                <input type="hidden" name="category_name" value="<?= ($h->id_category == 1) ? 'Hamburgueres' : 'Pizzas' ?>">
                                <input type="hidden" name="product_description" value="<?= $h->product_description ?>">
                                <input type="hidden" name="img" value="<?= $h->img ?>">
                                <input type="hidden" name="price" value="<?= $h->price ?>">
                            </span>
                            <!--<a href="<?//= $BASE ?>/products/show/<?//= $h->id ?>"> -->
                            <figure class="item">
                                <img class="mx-auto" src="<?= $BASE ?>/public/img/products/category_<?=$h->id_category?>/id_<?= $h->id ?>/<?= $h->img ?>" alt="<?= $h->img ?>" title="<?= $h->product_name ?>">
                                <figcaption><?= $h->product_name ?></figcaption>
                            </figure>
                            <!-- </a> -->
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
                        <a data-toggle="modal" data-target="#itemModal" id="product_<?= $data->id ?>" onclick="callItem(this)">
                            <span style="display:none;" id="inputItens">
                                <input type="hidden" name="id" value="<?= $data->id ?>">
                                <input type="hidden" name="id_category" value="<?= $data->id_category ?>">
                                <input type="hidden" name="product_name" value="<?= $data->product_name ?>">
                                <input type="hidden" name="category_name" value="<?= ($data->id_category == 1) ? 'Hamburgueres' : 'Pizzas' ?>">
                                <input type="hidden" name="product_description" value="<?= $data->product_description ?>">
                                <input type="hidden" name="img" value="<?= $data->img ?>">
                                <input type="hidden" name="price" value="<?= $data->price ?>">
                            </span>
                            <!-- <a href="<?//= $BASE ?>/products/show/<?//= $data->id ?>"> -->
                            <figure class="item"><img class="mx-auto" src="<?= $BASE ?>/public/img/products/category_<?=$data->id_category?>/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>">
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
        <section class="homeBlogSection bg-light">
            <header class="imgBackgroundArea homeBlog d-flex flex-wrap justify-content-center align-items-center flex-column">
                <span style="z-index: 9999999;">
                    <h2 class="text-left">Conheça nosso blog</h2>
                    <h3 class="text-left"><a href="<?=$BASE?>/posts" style="color:#fff!important">ùltimas noticias</a></h3>
                </span>
            </header>
            <div class="owl-carousel owl-theme">
                <?php foreach ($posts as $data) { ?>
                    <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>">
                        <figure class="item overflow-hidden img-section-max"><img class="object-fit" src="<?= $BASE ?>/public/img/posts/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->title ?>" title="<?= $data->title ?>">
                            <figcaption class="img-fig"><?= $data->title ?></figcaption>
                        </figure>
                    </a>
                <?php } ?>
            </div>
        </section>
    </div>
</article>

<!-- Modal -->
<script>
    function callItem(item) {
        // Get the information in the selected product
        let qtdInputs, inputs, values, i;
        // Count inputs
        qtdInputs = document.querySelector(`#${item.id} #inputItens`).children;
        // get Inputs
        inputs = document.querySelector(`#${item.id} #inputItens`).children;
        values = [];
        for (i = 0; i < qtdInputs.length; i++) {
            // Store on array
            values[i] = inputs[i].defaultValue;
        }
        // Product values
        let id, id_category, product_name, category_name, product_description, img, price;
        // Get array values
        id = values[0];
        id_category = values[1];
        product_name = values[2];
        category_name = values[3];
        product_description = values[4];
        img = values[5];
        price = values[6];
        // console.log(id, product_name, category_name, product_description, img, price);
        let itemModal = document.getElementById('itemModal');
        // console.log(itemModal[1]);
        let url = window.location.href;
        let modalContent =
            `<div class="modal-dialog" role="document">
                <div class="modal-content">
                    <header class="modal-header">
                    <h3 class="modal-title" id="name">${product_name}</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </header>
                    <div class="modal-body">
                    <figure>
                    <img src="${url}public/img/products/category_${id_category}/id_${id}/${img}" alt="${img}" title="${product_name}">
                        <figcaption>
                            <p>Categoria: <a href='${url}categories/show/${id_category}'>${category_name}</a></p>
                            <p>${product_description = values[4]}</>
                            <p>Valor: <a href='${url}categories/show/${id_category}'>R$ ${price}</a></p>
                        </figcaption>
                    </figure>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" style="background:#fff;color:#676767;border:1px solid #ccc" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>`;
        itemModal.innerHTML = modalContent;
    }
</script>
<section class="modal fade" style="top: -1%!important;z-index:999999999;" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
</section>
<!-- End modal -->