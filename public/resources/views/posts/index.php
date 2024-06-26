<?php

$posts = valueParamExistsOrDefault($posts);
$havePosts = count($posts) > 0;

$linkCommonHtmlAttributes
    = 'hx-push-url="true"  
    hx-swap="show:body:top"  
    hx-target="[data-js=\'result-itens-container\']"  
    hx-select="[data-js=\'result-itens-container\'] [data-js=\'loop-item\']"';

?>

<header class="imgBackgroundArea homeBlog d-flex flex-wrap justify-content-center align-items-center flex-column" data-js="top-page-header">
    <span>
        <h1 class="text-left">Blog</h1>
        <h2 class="text-left">Últimas noticias</h2>
    </span>
</header>

<article class="blogArticle">
    <?php

    App\Classes\DynamicLinks::addLink($BASE, 'posts', 'Adicionar mais postagens');

    if ($havePosts) :

    ?>
        <section class="blog flex-wrap card-group itens-results-container" data-js="result-itens-container" hx-boost="true" hx-target="body" hx-swap="outerHTML">

            <?php foreach ($posts as $data) :

                $postTextString = objParamExistsOrDefault($data, 'body', '');
                
                $postText = preg_replace('/<\/?p[^>]*>/', '', $postTextString);

            ?>

                <figure class="d-flex justify-content-center blogFig card" data-js="loop-item">

                    <a href="<?= $BASE ?>/posts/show/<?= $data->id ?>">
                        <div class="imgMax">
                            <img class="card-img-top" src="<?= $BASE ?>/<?= imgOrDefault('posts', $data->img, $data->id) ?>" alt="<?= $data->img ?>" title="<?= $data->title ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';">
                        </div>

                        <figcaption class="blogBody card-body">
                            <h5 class="blogTitle card-title">
                                <?= $data->title ?>
                            </h5>
                            <div class="blogSpan card-text">
                                <?= $postText ?>
                            </div>
                        </figcaption>
                    </a>

                    <small class="updated card-text">Atualizado em <?= dateFormat($data->updated_at) ?></small>

                    <?php App\Classes\DynamicLinks::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');

                    ?>
                </figure>

            <?php endforeach; ?>

        </section>
    <?php endif; ?>

</article>