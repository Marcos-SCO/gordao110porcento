<h1>Categorias</h1>

<?php
Core\Controller::createMore($BASE, 'products', 'Adicionar mais produtos');
?>
<?php foreach ($products as $data) { ?>
    <div>
        <a href="<?= $BASE ?>/products/show/<?= $data->id ?>">
            <h1><?= $data->product_name ?></h1>
        </a>
        <?php
        Core\Controller::editDelete($BASE, 'products', $data, 'Quer mesmo deletar esse produto?');
        ?>
    </div>
<?php } ?>