<h1>Welcome</h1>

<?php if ($_SESSION['user_status'] == 1) { ?>
    <a href="<?= $BASE ?>/gallery/create">Adicionar mais imagens</a>
<?php } ?>
<?php foreach ($gallery as $data) { ?>
    <div>
        <a href="<?= $BASE ?>/gallery/show/<?= $data->id ?>">
            <h1><?= $data->img_title ?></h1>
            <figure>
                <img src="<?= $BASE ?>/public/img/gallery/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->img_title ?>">
                <figcaption style="white-space: nowrap;width: 450px;overflow: hidden;text-overflow: ellipsis;">
                </figcaption>
            </figure>
        </a>

        <?php
        if (($data->user_id == $_SESSION['user_id']) or ($_SESSION['adm_id'] == 1)) {
        ?>
            <a href="<?= $BASE ?>/gallery/edit/<?= $data->id ?>" class="btn btn-dark">
                Editar
            </a>
            <a href="<?= $BASE ?>/gallery/delete/<?= $data->id ?>" method="post" name="delete" onclick="return confirm('Quer Mesmo deletar?')">Deletar</a>
        <?php } ?>
    </div>
<?php } ?>