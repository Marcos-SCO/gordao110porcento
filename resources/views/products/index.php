<h1>Categorias</h1>

<?php if ($_SESSION['user_status'] == 1) { ?>
    <a href="<?= $BASE ?>/products/create">Adicionar mais produtos</a>
<?php } ?>
<?php foreach ($products as $data) { ?>
    <div>
        <a href="<?= $BASE ?>/products/show/<?= $data->id ?>">
            <h1><?= $data->product_name ?></h1>
        </a>
        <?php if (($data->user_id == $_SESSION['user_id']) || ($_SESSION['adm_id'] == 1)) { ?>
            <a href="<?= $BASE ?>/products/edit/<?= $data->id ?>" class="btn btn-dark">Editar</a>
            <a href="<?= $BASE ?>/products/delete/<?= $data->id ?>" method="post" name="delete" onclick="return confirm('Quer Mesmo deletar a categoria?')">Deletar</a>
        <?php } ?>
    </div>
<?php } ?>