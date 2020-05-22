<article>
    <header>
        <h1>Últimas Postagens</h1>
    </header>
    <?php
    Core\Controller::createMore($BASE, 'posts', 'Adicionar mais postagens');
    ?>
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
            Core\Controller::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');
            ?>
        </div>
    <?php } ?>
</article>