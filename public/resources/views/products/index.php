<?php

$userStatus = indexParamExistsOrDefault($_SESSION, 'user_status');

$isAdminUser = $userStatus && $userStatus == 1;

?>
<header class="imgBackgroundArea productHeader" data-js="top-page-header">
    <h1>Todas as nossas Ofertas</h1>
</header>

<?php if ($isAdminUser) : ?>
    <section class="adm">
        <div class="add d-flex flex-wrap p-2 justify-content-center">
            <?php

            App\Classes\DynamicLinks::addLink($BASE, 'products', 'Adicionar produtos');

            App\Classes\DynamicLinks::addLink($BASE, 'categories', 'Adicionar categorias');
            ?>
        </div>
    </section>
<?php endif; ?>

<article class="products flex-wrap">

    <?php // Products categories dropdown
    include_once __DIR__ . '/../components/products/productCategoriesDropdown.php';

    ?>

    <section class="products flex-wrap card-group itens-results-container" data-js="result-itens-container">
        <?php // Products data loop
        include_once __DIR__ . '/../components/products/productsDataLoop.php';

        ?>
    </section>

</article>