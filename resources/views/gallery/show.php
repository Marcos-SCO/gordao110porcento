<?php
Core\Controller::createMore($BASE, 'gallery', 'Quer adicionar Mais imagens?');
?>
<div>
    <h1><?= $data->img_title ?></h1>
    <small class="bg-secondary text-white p-2 mb-3">
        <?php
        if ($_SESSION['user_status'] == 1) { ?>
            Imagem adicionada por <a href="<?= $BASE ?>/users/show/<?= $user->id ?>"><?= $user->name ?></a> em <?= $data->created_at ?>
        <?php } ?>
    </small>
    <figure>
        <img src="<?= $BASE ?>/<?= imgOrDefault('gallery', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>">
    </figure>
</div>

<?php
Core\Controller::editDelete($BASE, 'gallery', $data, 'Quer mesmo deletar essa foto?');
?>