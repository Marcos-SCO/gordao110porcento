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

        // PostsSection
        include_once __DIR__ . '/../components/posts/postsSection.php';

    endif;

    ?>

</article>