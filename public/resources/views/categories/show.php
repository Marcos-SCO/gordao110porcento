<?php

$isSectionActiveUser = isSessionActiveUser();

$categoryName = objParamExistsOrDefault($data, 'category_name');
$categoryDescription = objParamExistsOrDefault($data, 'category_description');

$dataCreatedAt = objParamExistsOrDefault($data, 'created_at');

$userName = objParamExistsOrDefault($user, 'name');
$userId = objParamExistsOrDefault($user, 'id');

$userUrl =  $BASE . '/users/show/' . $userId;

?>

<header class="categoryHeader productHeader imgBackgroundArea" data-js="top-page-header">
    <h1><?= $categoryName; ?></h1>
    <p><?= $categoryDescription ?></p>

    <?php if (!$isSectionActiveUser) : ?>
        <small class='mb-3 z-3'>
            Categoria adicionada por <a href='<?= $userUrl; ?>' hx-boost="true"> <?= $userName; ?>
            </a> em <?= $dataCreatedAt; ?>
        </small>
    <?php endif; ?>
</header>

<?php

if ($isSectionActiveUser) :

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

        // Products data loop
        if ($products) include_once __DIR__ . '/../components/products/productsDataLoop.php';

        ?>
    </section>

</article>