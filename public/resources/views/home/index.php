<article>
    <div class="section">

        <section class="homeAbout">
            <header class="homeHeaderAbout imgBackgroundArea d-flex flex-wrap justify-content-center flex-row">
                <span>
                    <img src="<?= $BASE ?>/public/resources/img/template/gordao110_logo_300px.png" alt="gordao110_logo.png" title="Gordão 110% logo">
                    <h3 class="text-left">Sobre nós</h3>
                </span>
            </header>
            <div class="about">
                <div data-anima="center">
                    <strong class="font-swashCaps lightText">Gordão a 110%</strong>
                    <p class="mt-2">Somos uma lanchonete e restaurante com mais de <a href="<?= $BASE ?>/about"><span class="activeYears link">vinte e três</span></a> anos de tradição. Já servimos todo tipo de refeição com nosso extenso <span class="link" id="menu">menu</span>, <a href="https://api.whatsapp.com/send?phone=5511916459334&text=Olá+Marcos+tudo+bem?+Vim+por+meio+do+link+no+site+%22Gordão+a+110%%22+e+gostaria+de+conversar+com+você." target="_blank">peça já!.</a> Te convidamos a se deliciar com nossas ofertas. Você terá a satisfação a 110% e garantia de qualidade.<br>É gordão ou nada! <a href="<?= $BASE ?>/about">Saiba mais</a></p>
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
        url = url.replace('/home', '/');

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
            <img src="${url}/public/resources/img/products/category_${id_category}/id_${id}/${img}" alt="${img}" title="${product_name}"  onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
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