<?php

function inlineStyleContent($styleValues, $printStyle = true)
{
  $styleItem = 'style="' . $styleValues . '"';

  if (!$printStyle) return $styleItem;

  echo $styleItem;
}

function inlineStyleTag($styleValues, $printTag = true)
{
  $styleTag = '<style>'.$styleValues . '</style>';

  if (!$printTag) return $styleTag;

  echo $styleTag;
}