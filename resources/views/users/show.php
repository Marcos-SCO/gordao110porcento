<section>
    <header>
        <h1><?= $user->name ?> <?= $user->last_name ?></h1>
    </header>
    <figure>
        <img src="<?= $BASE ?>/public/img/users/id_<?= $user->id ?>/<?= $user->img ?>" alt="<?= $user->img ?>" title="<?= $user->name ?>">
        <figcaption>Sobre <?= $user->name ?><p><?= $user->bio ?></p>
        </figcaption>
    </figure>
</section>

<?= ($_SESSION['user_status'] != null) ? "<ul><li><a href='$BASE/users'>id $user->id - $user->name - $user->email</a></li></ul>" : ''; ?>

<?php if (count($posts) > 0) { ?>
    <article class="flex flex-column justify-content-center">
        <header class="text-center m-auto p-3">
            <h3>Postagens feitas por <?= $user->name ?></h3>
        </header>
        <section class="blog flex-wrap card-group">
            <?php foreach ($posts as $data) { ?>
                <figure class="d-flex justify-content-center blogFig card">
                    <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>">
                        <div class="imgMax">
                            <img class="card-img-top" src="<?= $BASE ?>/public/img/posts/id_<?= $data->id ?>/<?= $data->img ?>" alt="<?= $data->img ?>" title="<?= $data->title ?>">
                        </div>
                        <figcaption class="blogBody card-body">
                            <h5 class="blogTitle card-title"><?= $data->title ?></h5>
                            <span class="blogSpan card-text"><?= $data->body ?></span>
                            <small class="updated card-text">Atualizado em <?= dateFormat($data->updated_at) ?></small>
                        </figcaption>
                    </a>
                    <?php
                    Core\Controller::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');
                    ?>
                </figure>
            <?php } ?>
        </section>
    <?php } ?>
    </article>