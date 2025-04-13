<?php

use App\Config\Config;

function activePageClass(array $pagesToActivate, string $pageName)
{
  $isInPage = in_array($pageName, $pagesToActivate);

  if ($isInPage) return 'active';
}

function whatsAppMessageLink()
{
  return Config::$PHONE_NUMBER_NUMBER_LINK;
}
