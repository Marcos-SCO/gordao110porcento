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
    include_once __DIR__ . '/../components/productCategoriesDropdown.php';

    ?>

    <section class="products flex-wrap card-group itens-results-container" data-js="result-itens-container" hx-swap="swap:1s">
        <?php

        if ($products) :

            foreach ($products as $data) :

        ?>
                <figure class="card" data-js="loop-item">
                    <img src="<?= $BASE ?>/<?= imgOrDefault('products', $data->img, $data->id, "/category_$data->id_category") ?>" title="<?= $data->product_name ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">

                    <figcaption class="card-body">
                        <h5 class="card-title"><?= $data->product_name ?></h5>
                        <?php

                        // Get category name from categories table
                        foreach ($categoryElements as $element) : ($element->id == $data->id_category) ? $categoryName = $element->category_name : '';
                        endforeach;

                        echo "<p class='card-text'>$data->product_description</p><p class='card-text'>Preço: $data->price</p><small class='text-muted'>Categoria: <a href='$BASE/categories/show/$data->id_category'> $categoryName</a></small><br>";

                        echo ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "<a href='$BASE/products/show/$data->id'>Ver detalhes</a>" : '';

                        ?>
                    </figcaption>

                    <?php

                    App\Classes\DynamicLinks::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');

                    ?>
                </figure>

        <?php endforeach;

        endif;

        ?>
    </section>

</article>