<h1>Todos nossos Produtos</h1>

<?php

use App\Models\Category;

Core\Controller::createMore($BASE, 'products', 'Adicionar mais produtos');
?>
<?php foreach ($products as $data) { ?>
    <figure>
        <img src="<?= $BASE ?>/public/img/products/id_<?= $data->id ?>/<?= $data->img ?>">
        <p><?= $data->product_name ?></p>
        <figcaption>
            <?php
            // Get category name from categories table
            foreach ($categoryElements as $element) : ($element->id == $data->id_category) ? $categoryName = $element->category_name : '';
            endforeach;
            echo "<p>$data->product_description<br>Preço: $data->price<br>Categoria: <a href='$BASE/categories/show/$data->id_category'> $categoryName</a></p>";
            ?>
        </figcaption>
        <a href="<?= $BASE ?>/products/show/<?= $data->id ?>">Ver detalhes</a>
        <?php
        Core\Controller::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');
        ?>
    </figure>
<?php } ?>

<aside>
    <header><h3>Categorias</h3></header>
    <ul>
        <?php
        foreach ($categoryElements as $category) {
            echo "<li><a href='$BASE/categories/show/$category->id'>$category->category_name</a></li>";
        }
        ?>
    </ul>
</aside>