<header class="categoryHeader productHeader imgBackgroundArea">
    <h1><?= $data->category_name ?></h1>
    <p><?= $data->category_description ?></p>
</header>
<?php
if ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) {
?>
    <small class="bg-light p-2 mb-3">Categoria adicionada por <a href="<?= $BASE ?>/users/show/<?= $user->id ?>"><?= $user->name ?></a> em <?= $data->created_at ?></small>
    <section class="adm d-flex flex-column align-content-start align-items-center">
        <?php
        Core\Controller::editDelete($BASE, 'categories', $data, "Quer deletar a categoria de $data->category_name?");
        ?>
        <div class="add d-flex flex-wrap flex-column p-2">
            <?php
            Core\Controller::createMore($BASE, 'products', 'Adicionar mais produtos');
            ?>
            <?php
            Core\Controller::createMore($BASE, 'categories', 'Adicionar mais categorias');
            ?>
        </div>
    </section>
<?php } ?>

<h4>Produtos com a categoria <?= $data->category_name ?></h4>

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
                <img src="<?= $BASE ?>/public/img/products/category_<?=$data->id_category?>/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>">
                <figcaption class="card-body">
                    <h5 class="card-title"><?= $data->product_name ?></h5>
                    <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
                    <?php
                    // Get category name from categories table
                    foreach ($categoryElements as $element) : ($element->id == $data->id_category) ? $categoryName = $element->category_name : '';
                    endforeach;
                    echo "<p class='card-text'>$data->product_description</p><p class='card-text'>Preço: $data->price</p><small class='text-muted'>Categoria: <a href='$BASE/categories/show/$data->id_category'> $categoryName</a></small><br>";
                    ?>
                    <a href="<?= $BASE ?>/products/show/<?= $data->id ?>">Ver detalhes</a>
                </figcaption>
                <?php
                Core\Controller::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');
                ?>
            </figure>
        <?php } ?>
    </section>
</article>