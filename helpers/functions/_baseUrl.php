<?php

/**
 * Get the base URL of the current page. For example, if the current page URL is
 * "https://example.com/dir/example.php?whatever" this function will return
 * "https://example.com/dir/" .
 *
 * @return string The base URL of the current page.
 */
function get_base_url()
{
  $protocol = filter_input(INPUT_SERVER, 'HTTPS');

  $protocol = $protocol ? "https" : "http";

  $host = filter_input(INPUT_SERVER, 'HTTP_HOST');

  $request_uri_full = filter_input(INPUT_SERVER, 'REQUEST_URI');

  $last_slash_pos = strrpos($request_uri_full, "/");

  if ($last_slash_pos === FALSE) {
    $request_uri_sub = $request_uri_full;
  } else {
    $request_uri_sub = substr($request_uri_full, 0, $last_slash_pos + 1);
  }

  return $protocol . "://" . $host . $request_uri_sub;
}
