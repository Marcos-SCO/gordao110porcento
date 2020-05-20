<h1>Categorias</h1>

<?php
if ($_SESSION['user_status'] == 1) {
?>
    <a href="<?= $BASE ?>/categories/create">Adicionar mais categorias</a>
<?php } ?>
<?php foreach ($categories as $data) { ?>
    <div>
        <a href="<?= $BASE ?>/categories/show/<?= $data->id ?>">
            <h1><?= $data->category_name ?></h1>
        </a>
        <?php
        if (($data->user_id == $_SESSION['user_id']) || ($_SESSION['adm_id'] == 1)) { ?>
            <a href="<?= $BASE ?>/categories/edit/<?= $data->id ?>" class="btn btn-dark">
                Editar
            </a>
            <a href="<?= $BASE ?>/categories/delete/<?= $data->id ?>" method="post" name="delete" onclick="return confirm('Quer Mesmo deletar a categoria?')">Deletar</a>
        <?php
        }
        ?>
    </div>
<?php } ?>