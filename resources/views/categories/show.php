<?php

$categoryName = $data->category_name;

?>

<header class="categoryHeader productHeader imgBackgroundArea">
    <h1><?= $categoryName; ?></h1>
    <p><?= $data->category_description ?></p>
    <?= ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "<small class='smallInfo'>Categoria adicionada por <a href='$BASE/users/show/$user->id'>$user->name</a> em " . dateFormat($data->created_at) . "</small>" : ''; ?>
</header>

<?php

if ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) :
?>
    <section>
        <header class="d-flex flex-column headerEdit imgBackgroundArea">
            <?php Core\Controller::editDelete($BASE, 'categories', $data, "CUIDADO!, você está prestes a deletar a categoria de $categoryName;. Essa ação será ireversivel, quer mesmo continuar?");

            ?>
        </header>

        <div class="adm">
            <div class="add d-flex flex-wrap p-2 justify-content-center">
                <?php

                Core\Controller::createMore($BASE, 'products', 'Adicionar mais produtos');

                Core\Controller::createMore($BASE, 'categories', 'Adicionar mais categorias');
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>

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
        <?php

        if (!$products) echo "<p>Categoria <strong>{$categoryName}</strong> não possui produtos cadastrados...</p>";

        if ($products) include_once __DIR__ . './_listProductItens.php';

        ?>
    </section>

</article>