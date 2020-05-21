<h1>Categorias</h1>

<?php
    Core\Controller::createMore($BASE, 'categories', 'Adicionar mais categorias');
?>
<?php foreach ($categories as $data) { ?>
    <div>
        <a href="<?= $BASE ?>/categories/show/<?= $data->id ?>">
            <h1><?= $data->category_name ?></h1>
        </a>
        <?php
        Core\Controller::editDelete($BASE, 'categories', $data, "Quer deletar a categoria de $data->category_name?");
        ?>
    </div>
<?php } ?>