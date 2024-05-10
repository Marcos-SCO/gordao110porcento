<?php

function httpRequestCurl($url, $method = 'GET', $data = array(), $headers = array())
{
  $ch = curl_init();

  if ($method == 'GET' && !empty($data)) {
    $url .= '?' . http_build_query($data);
  }

  if ($method == 'POST') {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  }

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);

  if ($response === false) {
    echo json_encode(['error' => true, 'message' => 'Curl error: ' . curl_error($ch)]);
    die();
  }

  curl_close($ch);

  return $response;
}