<?php

if (!$data) return;

$postTextString = objParamExistsOrDefault($data, 'body', '');

$postText = preg_replace('/<\/?p[^>]*>/', '', $postTextString);

$postId = objParamExistsOrDefault($data, 'id');
$postSlug = objParamExistsOrDefault($data, 'slug');

$postImg = objParamExistsOrDefault($data, 'img');
$postTitle = objParamExistsOrDefault($data, 'title');

$postUrl = $BASE . '/posts/';
if ($postSlug) $postUrl = $BASE . '/post/' . $postSlug;

$postImg = objParamExistsOrDefault($data, 'img');

$postImgUrl = $BASE . '/' . imgOrDefault('posts', $postImg, $postId);

$postUpdatedAt = objParamExistsOrDefault($data, 'updated_at');

$itemCounter = isset($itemCounter) ? $itemCounter : 0;
$loadingImgValue = $itemCounter <= 3 ? 'eager' : 'lazy';

?>

<figure class="post-card d-flex justify-content-center blogFig card" data-js="loop-item" data-js="post-card">

  <a href="<?= $postUrl ?>">

    <div class="imgMax">
      <img class="card-img-top" src="<?= $postImgUrl ?>" alt="<?= $postImg ?>" title="<?= $postTitle ?>" width="299.2" height="255" onerror="this.onerror=null;this.src='<?= $BASE ?>/public/resources/img/not_found/no_image.jpg';" loading="<?= $loadingImgValue; ?>">
    </div>

    <figcaption class="blogBody card-body">
      <h5 class="blogTitle card-title">
        <?= $postTitle ?>
      </h5>

      <div class="blogSpan card-text">
        <?= $postText ?>
      </div>
    </figcaption>
  </a>

  <small class="updated card-text">Atualizado em <?= dateFormat($postUpdatedAt) ?></small>

  <?php App\Classes\DynamicLinks::editDelete($BASE, 'posts', $data, 'Quer mesmo deletar essa postagem?');

  ?>
</figure>