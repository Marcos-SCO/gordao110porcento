<?php

function getYoutubeVideoIdFromUrl($url)
{
  $urlComponents = parse_url($url);
  if (!$urlComponents) return false;

  $queryComponent =
    isset($urlComponents['query']) ? $urlComponents['query'] : false;

  if (!$queryComponent) return false;

  parse_str($queryComponent, $params);
  return $params['v'];
}
