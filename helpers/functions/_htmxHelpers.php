<?php

function getHtmxMainTagAttributes(): string
{
  return 'hx-push-url="true"  
  hx-swap="show:window:top"  
  hx-target="main"  
  hx-select="main > *"';
}