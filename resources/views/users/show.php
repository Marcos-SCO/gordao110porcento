<h1><?= $user->name ?> <?= $user->last_name ?></h1>
<figure>
    <img src="<?= $BASE ?>/public/img/users/id_<?= $user->id ?>/<?= $user->img ?>" alt="<?= $user->img ?>" title="<?= $user->name ?>">
    <figcaption>
        <p>
            <?= $user->bio ?>
        </p>
    </figcaption>
</figure>
<ul>
    <li>id <?= $user->id ?> - <?= $user->name ?> - <?= $user->email ?></li>
</ul>

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
        <?php if ($data->user_id == $_SESSION['user_id']) { ?>
            <a href="<?= $BASE ?>/posts/edit/<?= $data->id ?>" class="btn btn-dark">Edit</a>
            <a href="<?= $BASE ?>/posts/delete/<?= $data->id ?>" method="post" name="delete" onclick="return confirm('Quer Mesmo deletar?')">Deletar</a>
        <?php } ?>
    </div>
<?php } ?>