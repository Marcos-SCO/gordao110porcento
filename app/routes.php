<?php

return [
  'GET' => [
    '/(?:$|home)/?' => 'Home@index',
    '/about/?' => 'About@index',

    '/products/?($|[0-9])+/?' => 'Products@index',
    '/gallery/?($|[0-9])+/?' => 'Gallery@index',
    
    '/posts/?($|[0-9])+/?' => 'Posts@index',
    '/posts/?show/($|[0-9])+/?' => 'Posts@show',
    
    '/categories/?($|[0-9])+/?' => 'Categories@index',

    '/categories/?show/($|[0-9]+)(?:/([0-9]+))?/' => 'Categories@show',

    '/contact/?($|[\w]+)/?' => 'Contact@index',

    // '/user/create' => 'User@create',
    // '/user/' => 'User@index',
    // '/user/($|[0-9])+' => 'User@show',
    
    // '/logout' => 'Login@destroy',

    '/login/?' => 'Users@login',

    '/users/?($|[0-9])+/?' => 'Users@index',

    '/users/?show/($|[0-9]+)(?:/([0-9]+))?/' => 'Users@show',

  ],

  'POST' => [
    '/login' => 'Login@store',
    '/user/store' => 'User@store',

    '/contact/?($|[\w]+)/send/?' => 'Contact@sendMessage',
    // '/contact/message/send/?' => 'Contact@sendMessage',
    // '/contact/work/send/?' => 'Contact@workSend',
    
  ],
];
