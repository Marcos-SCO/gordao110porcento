<?php

function activePageClass(array $pagesToActivate, string $pageName)
{
  $isInPage = in_array($pageName, $pagesToActivate);

  if ($isInPage) return 'active';
}

function whatsAppMessageLink()
{
  return 'https://api.whatsapp.com/send?phone=5511916459334&text=Olá+Marcos+tudo+bem?+Vim+por+meio+do+link+no+site+%22Gordão+a+110%%22+e+gostaria+de+conversar+com+você.';
}
