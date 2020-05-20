<?php
if ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) {
?>
    <a href="<?= $BASE ?>/categories/create">Adicionar mais categorias</a>
<?php } ?>
<div>
    <h1><?= $data->category_name ?></h1>
    <?php
    if ($_SESSION['user_status'] && $_SESSION['user_status'] == 1) {
    ?>
        <small class="bg-secondary text-white p-2 mb-3">
            Categoria adicionada por <a href="<?= $BASE ?>/users/show/<?= $user->id ?>"><?= $user->name ?></a> em <?= $data->created_at ?>
        </small>
    <?php } ?>
    <figure>
        <img src="<?= $BASE ?>/public/img/categories/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->category_name ?>">
        <figcaption>
            <p><?= $data->category_description ?></p>
        </figcaption>
    </figure>
</div>
<?php
if ($_SESSION['user_id'] && $_SESSION['adm_id']) {
    if ($data->user_id == $_SESSION['user_id'] || $_SESSION['adm_id'] == 1) {
?>
        <a href="<?= $BASE ?>/categories/edit/<?= $data->id ?>" class="btn btn-dark">
            Editar
        </a>
        <a href="<?= $BASE ?>/categories/delete/<?= $data->id ?>" method="post" name="delete" onclick="return confirm('Quer Mesmo deletar essa imagem?')">Deletar</a>
<?php
    }
}
?>
<h4>Produtos com a categoria <?= $data->category_name ?></h4>
<?php foreach ($products as $data) { ?>
    <figure>
        <a href="<?= $BASE ?>/products/show/<?= $data->id ?>">
            <img src="<?= $BASE ?>/public/img/products/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->product_name ?>">
        </a>
        <figcaption>
            <h3><?= $data->product_name ?></h3>
            <h5>Preço <?= $data->price ?></h5>
            <p><?= $data->product_description ?></p>
        </figcaption>
    </figure>
<?php } ?>