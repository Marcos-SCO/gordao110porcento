<?php
$posts = valueParamExistsOrDefault($posts);

if (!$posts) return;

?>
<section class="homeBlogSection bg-light">
  <header class="imgBackgroundArea homeBlog d-flex flex-wrap justify-content-center align-items-center flex-column">
    <span style="z-index: 9999999;">
      <a href="<?= $BASE ?>/posts" style="color:#fff!important">
        <h2 class="text-left">Conheça nosso blog</h2>
        <h3 class="text-left">Últimas noticias</h3>
      </a>
    </span>
  </header>

  <div class="owl-carousel owl-theme" data-js="blog-posts-section" hx-boost="true" hx-target="body" hx-swap="outerHTML">
    <?php foreach ($posts as $postItem) :

      $postId = objParamExistsOrDefault($postItem, 'id');
      $postSlug = objParamExistsOrDefault($postItem, 'slug');
      $postTitle = objParamExistsOrDefault($postItem, 'title');
      $postImg = objParamExistsOrDefault($postItem, 'img');

      $postUrl = $BASE . '/posts/';
      if ($postSlug) $postUrl = $BASE . '/post/' . $postSlug;

    ?>
      <a href="<?= $postUrl ?>">
        <figure class="item overflow-hidden img-section-max">
          <img class="object-fit" src="<?= $BASE ?>/public/resources/img/posts/id_<?= $postId ?>/<?= $postImg ?>" alt="<?= $postTitle ?>" title="<?= $postTitle ?>" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';" oading="lazy" width="246" height="184">

          <figcaption class="img-fig"><?= $postTitle ?></figcaption>
        </figure>
      </a>
    <?php endforeach; ?>
  </div>

</section>