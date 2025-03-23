<?php

$defaultImg =  $RESOURCES_PATH . '/img/slider/pizzasRefris_template_400.jpg';

?>

<div id="hero" data-js="heroSlider" class="hero d-flex justify-content-center align-items-center flex-column" style="transition: all .25s; background-image:url(<?= $defaultImg; ?>);">

  <header class="p-4 d-flex flex-column justify-content-center">
    <div class="headerQuotes">
      <h1 id="quoteTitle" data-js="quoteTitle" class="text-left font-swashCaps" style="color:#fff;">Gordão a 110%</h1>

      <p id="quote" data-js="quote" style="color:#fff;">O melhor restaurante e lanchonete da região</p>
    </div>

    <a href="<?= whatsAppMessageLink(); ?>" target="_blank">Pedir agora</a>
  </header>

  <i id="prev" class="prev fa fa-angle-left"></i>
  <i id="next" class="next fa fa-angle-right"></i>

  <ul id="heroCounter" class="heroCounter" data-js="heroCounter"></ul>
</div>