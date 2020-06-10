<header class="categoryHeader productHeader imgBackgroundArea">
    <h1><?= $data->category_name ?></h1>
    <p><?= $data->category_description ?></p>
    <?= ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "<small class='smallInfo'>Categoria adicionada por <a href='$BASE/users/show/$user->id'>$user->name</a> em ". dateFormat($data->created_at)."</small>" : ''; ?>
</header>
<?php
if ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) {
?>
    <section>
        <header class="d-flex flex-column headerEdit imgBackgroundArea">
            <?php
            Core\Controller::editDelete($BASE, 'categories', $data, "CUIDADO!, você está prestes a deletar a categoria de $data->category_name. Essa ação será ireversivel, quer mesmo continuar?");
            ?>
        </header>
        <div class="adm">
            <div class="add d-flex flex-wrap p-2 justify-content-center">
                <?php
                Core\Controller::createMore($BASE, 'products', 'Adicionar mais produtos');
                ?>
                <?php
                Core\Controller::createMore($BASE, 'categories', 'Adicionar mais categorias');
                ?>
            </div>
        </div>
    </section>
<?php } ?>

<article class="products flex-wrap flex-column">
    <aside class="productDropdown">
        <p>Apresentar por categorias</p>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Selecionar</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <?php
                echo "<li><a href='$BASE/products' class='dropdown-item'>Todas</a></li>";
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
                <img src="<?= $BASE ?>/<?=imgOrDefault('products',$data->img,$data->id, "/category_$data->id_category")?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>" onerror="this.onerror=null;this.src='<?=$BASE?>/public/img/not_found/no_image.jpg';">

                <figcaption class="card-body">
                    <h5 class="card-title"><?= $data->product_name ?></h5>
                    <?php
                    // Get category name from categories table
                    foreach ($categoryElements as $element) : ($element->id == $data->id_category) ? $categoryName = $element->category_name : '';
                    endforeach;
                    echo "<p class='card-text'>$data->product_description</p><p class='card-text'>Preço: $data->price</p><small class='text-muted'>Categoria: <a href='$BASE/categories/show/$data->id_category'> $categoryName</a></small><br>";
                    ?>
                    <?= ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "<a href='$BASE/products/show/$data->id'>Ver detalhes</a>" : ''; ?>
                </figcaption>
                <?php
                Core\Controller::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');
                ?>
            </figure>
        <?php } ?>
    </section>
</article>