<header class="imgBackgroundArea productHeader">
    <h1>Todas as nossas Ofertas</h1>
</header>
<?php if ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) { ?>
    <section class="adm">
        <div class="add d-flex flex-wrap p-2 justify-content-center">
            <?php
            Core\Controller::createMore($BASE, 'products', 'Adicionar mais produtos');
            ?>
            <?php
            Core\Controller::createMore($BASE, 'categories', 'Adicionar mais categorias');
            ?>
        </div>
    </section>
<?php } ?>

<article class="products flex-wrap">
    <aside class="productDropdown">
        <p>Apresentar por categorias</p>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Selecionar</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php
                foreach ($categoryElements as $category) {
                    echo "<li><a href='$BASE/categories/show/$category->id' class='dropdown-item'>$category->category_name</a></li>";
                }
                ?>
            </ul>
        </div>
    </aside>
    <section class="products flex-wrap card-group">
        <?php foreach ($products as $data) { ?>
            <figure class="card">
                <img src="<?= $BASE ?>/<?=imgOrDefault('products', $data->img, $data->id, "/category_$data->id_category")?>" title="<?= $data->product_name ?>" onerror="this.onerror=null;this.src='<?=$BASE?>/public/img/not_found/no_image.jpg';">

                <figcaption class="card-body">
                    <h5 class="card-title"><?= $data->product_name ?></h5>
                    <?php
                    // Get category name from categories table
                    foreach ($categoryElements as $element) : ($element->id == $data->id_category) ? $categoryName = $element->category_name : '';
                    endforeach;
                    echo "<p class='card-text'>$data->product_description</p><p class='card-text'>Preço: $data->price</p><small class='text-muted'>Categoria: <a href='$BASE/categories/show/$data->id_category'> $categoryName</a></small><br>";
                    ?>
                    <?=($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "<a href='$BASE/products/show/$data->id'>Ver detalhes</a>" : '';?>
                </figcaption>
                <?php
                Core\Controller::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');
                ?>
            </figure>
        <?php } ?>
    </section>
</article>