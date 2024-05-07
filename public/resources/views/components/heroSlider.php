<?php

$defaultImg =  $BASE . '/public/resources/img/slider/pizzasRefris_template_400.jpg';

?>

<div id="hero" data-js="heroSlider" class="hero d-flex justify-content-center align-items-center flex-column" style="transition: all .25s; background-image:url(<?= $defaultImg; ?>);">

  <header class="p-4 d-flex flex-column justify-content-center">
    <div class="headerQuotes">
      <h1 id="quoteTitle" data-js="quoteTitle" class="text-left font-swashCaps" style="color:#fff;">Gordão a 110%</h1>

      <p id="quote" data-js="quote" style="color:#fff;">O melhor restaurante e lanchonete da região</p>
    </div>

    <a href="https://api.whatsapp.com/send?phone=5511916459334&text=Olá+Marcos+tudo+bem?+Vim+por+meio+do+link+no+site+%22Gordão+a+110%%22+e+gostaria+de+conversar+com+você." target="_blank">Pedir agora</a>
  </header>

  <i id="prev" class="prev fa fa-angle-left"></i>
  <i id="next" class="next fa fa-angle-right"></i>

  <ul id="heroCounter" class="heroCounter" data-js="heroCounter"></ul>
</div>