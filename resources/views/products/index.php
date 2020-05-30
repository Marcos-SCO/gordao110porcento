<header class="productHeader homeBlog">
    <h1>Todos nossos Produtos</h1>
</header>
<?php

use App\Models\Category;

Core\Controller::createMore($BASE, 'products', 'Adicionar mais produtos');
?>
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
                <img src="<?= $BASE ?>/public/img/products/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>">
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