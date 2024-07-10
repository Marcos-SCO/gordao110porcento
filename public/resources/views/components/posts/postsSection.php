<?php

if (!$posts) return;

?>

<section class="blog flex-wrap card-group itens-results-container" data-js="result-itens-container" hx-boost="true" hx-target="body" hx-swap="outerHTML">

  <?php
  $itemCounter = 0;

  foreach ($posts as $data) :
    $itemCounter += 1;

    // Post card
    // include __DIR__ . '/../components/posts/postCard.php';
    include 'postCard.php';

  endforeach;

  ?>

</section>