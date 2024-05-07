<?php

$svgArray = [];

function getSvg($svgName)
{
  global $svgArray;

  return isset($svgArray[$svgName]) ? $svgArray[$svgName] : false;
}
