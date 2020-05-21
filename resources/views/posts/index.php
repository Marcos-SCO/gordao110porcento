<h1>Welcome</h1>

<?php if ($_SESSION['user_status'] == 1) { ?>
    <a href="<?= $BASE ?>/posts/create">Criar uma nova postagem</a>
<?php } ?>

<?php foreach ($posts as $data) { ?>
    <div>
        <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>">
            <h1><?= $data->title ?></h1>
            <figure>
                <img src="<?= $BASE ?>/public/img/posts/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->title ?>">
                <figcaption style="white-space: nowrap;width: 450px;overflow: hidden;text-overflow: ellipsis;">
                    <p><?= $data->body ?></p>
                </figcaption>
            </figure>
        </a>
        <?php
        if (($data->user_id == $_SESSION['user_id']) or ($_SESSION['adm_id'] == 1)) {
        ?>
            <a href="<?= $BASE ?>/posts/edit/<?= $data->id ?>" class="btn btn-dark">
                Editar
            </a>
            <a href="<?= $BASE ?>/posts/delete/<?= $data->id ?>" method="post" name="delete" onclick="return confirm('Quer Mesmo deletar?')">Deletar</a>
        <?php } ?>
    </div>
<?php } ?>