<?php

$posts = valueParamExistsOrDefault($posts);
$havePosts = count($posts) > 0;

?>

<header class="imgBackgroundArea homeBlog d-flex flex-wrap justify-content-center align-items-center flex-column">
    <span>
        <h1 class="text-left">Blog</h1>
        <h2 class="text-left">Últimas noticias</h2>
    </span>
</header>

<article class="blogArticle">
    <?php

    Helpers\Classes\DynamicLinks::addLink($BASE, 'posts', 'Adicionar mais postagens');

    if ($havePosts) :

    ?>
        <section class="blog flex-wrap card-group">

            <?php foreach ($posts as $data) : ?>
                <figure class="d-flex justify-content-center blogFig card">
                    <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>">
                        <div class="imgMax">
                            <img class="card-img-top" src="<?= $BASE ?>/<?= imgOrDefault('posts', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->title ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
                        </div>
                        <figcaption class="blogBody card-body">
                            <h5 class="blogTitle card-title"><?= $data->title ?></h5>
                            <span class="blogSpan card-text"><?= $data->body ?></span>
                        </figcaption>
                    </a>
                    <small class="updated card-text">Atualizado em <?= dateFormat($data->updated_at) ?></small>
                    <?php
                    Helpers\Classes\DynamicLinks::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');
                    ?>
                </figure>
            <?php endforeach; ?>

        </section>
    <?php endif; ?>

</article>