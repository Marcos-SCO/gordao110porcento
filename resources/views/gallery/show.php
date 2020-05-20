<?php
if ($_SESSION['user_status'] == 1) { ?>
    <a href="<?= $BASE ?>/gallery/create">Adicionar mais imagens para galleria</a>
<?php } ?>
<div>
    <h1><?= $data->img_title ?></h1>
    <small class="bg-secondary text-white p-2 mb-3">
        <?php
        if ($_SESSION['user_status'] == 1) { ?>
            Imagem adicionada por <a href="<?= $BASE ?>/users/show/<?= $user->id ?>"><?= $user->name ?></a> em <?= $data->created_at ?>
        <?php } ?>
    </small>
    <figure>
        <img src="<?= $BASE ?>/public/img/gallery/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>">
    </figure>
</div>

<?php
if (($data->user_id == $_SESSION['user_id']) or ($_SESSION['adm_id'] == 1)) {
?>
    <a href="<?= $BASE ?>/gallery/edit/<?= $data->id ?>" class="btn btn-dark">
        Editar
    </a>
    <a href="<?= $BASE ?>/gallery/delete/<?= $data->id ?>" method="post" name="delete" onclick="return confirm('Quer Mesmo deletar essa imagem?')">Deletar</a>
<?php } ?>