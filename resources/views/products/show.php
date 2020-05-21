<?php if ($_SESSION['user_status'] == 1) { ?>
    <a href="<?= $BASE ?>/products/create">Adicionar mais produtos</a>
<?php } ?>
<div>
    <h1><?= $data->product_name ?></h1>
    <small class="bg-secondary text-white p-2 mb-3">
        <?php if ($_SESSION['user_status'] != null) { ?>
            Produto adicionado por <a href="<?= $BASE ?>/users/show/<?= $user->id ?>"><?= $user->name ?></a> em <?= $data->created_at ?>
        <?php } ?>
    </small>
    <figure>
        <img src="<?= $BASE ?>/public/img/products/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>">
        <figcaption>
            <p><?= $data->product_description ?></p>
        </figcaption>
    </figure>
</div>

<?php if (($data->user_id == $_SESSION['user_id']) || ($_SESSION['adm_id'] == 1)) { ?>
    <a href="<?= $BASE ?>/products/edit/<?= $data->id ?>" class="btn btn-dark">Editar</a>
    <a href="<?= $BASE ?>/products/delete/<?= $data->id ?>" method="post" name="delete" onclick="return confirm('Quer Mesmo deletar essa imagem?')">Deletar</a>
<?php } ?>