<?php

return [
  'POST' => [
    '/login' => 'Login@store',
    '/user/store' => 'User@store',
  ],
  'GET' => [
    '/(?:$|home)/?' => 'Home@index',
    '/about/?' => 'About@index',

    '/products/?($|[0-9])+' => 'Products@index',
    '/gallery/?($|[0-9])+' => 'Gallery@index',
    
    '/posts/?($|[0-9])+' => 'Posts@index',
    '/posts/?show/($|[0-9])+' => 'Posts@show',
    
    '/categories/?($|[0-9])+' => 'Categories@index',
    '/categories/?show/($|[0-9]+)(?:/([0-9]+))?' => 'Categories@show',

    '/contact/?($|[\w]+)/?' => 'Contact@index',

    '/user/create' => 'User@create',
    '/user/' => 'User@index',
    '/user/($|[0-9])+' => 'User@show',
    '/login' => 'Login@index',
    '/logout' => 'Login@destroy',
  ],
];
