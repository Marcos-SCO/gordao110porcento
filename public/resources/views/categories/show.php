<?php

$categoryName = $data->category_name;

?>

<header class="categoryHeader productHeader imgBackgroundArea" data-js="top-page-header">
    <h1><?= $categoryName; ?></h1>
    <p><?= $data->category_description ?></p>

    <?= ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) ? "<small class='smallInfo'>Categoria adicionada por <a href='$BASE/users/show/$user->id'>$user->name</a> em " . dateFormat($data->created_at) . "</small>" : ''; ?>
</header>

<?php

if ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) :
?>
    <section>
        <header class="d-flex flex-column headerEdit imgBackgroundArea">
            <?php App\Classes\DynamicLinks::editDelete($BASE, 'categories', $data, "CUIDADO!, você está prestes a deletar a categoria de $categoryName;. Essa ação será ireversivel, quer mesmo continuar?");

            ?>
        </header>

        <div class="adm">
            <div class="add d-flex flex-wrap p-2 justify-content-center">
                <?php

                App\Classes\DynamicLinks::addLink($BASE, 'products', 'Adicionar mais produtos');

                App\Classes\DynamicLinks::addLink($BASE, 'categories', 'Adicionar mais categorias');
                ?>
            </div>
        </div>
    </section>

<?php endif; ?>

<article class="products flex-wrap flex-column">

    <?php // Products categories dropdown
    include_once __DIR__ . '/../components/products/productCategoriesDropdown.php';

    ?>

    <section class="products flex-wrap card-group" data-js="result-itens-container">
        <?php

        if (!$products) echo "<p>Categoria <strong>{$categoryName}</strong> não possui produtos cadastrados...</p>";

        if ($products) // Products data loop
        include_once __DIR__ . '/../components/products/productsDataLoop.php';

        ?>
    </section>

</article>