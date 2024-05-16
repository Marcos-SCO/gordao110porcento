<?php

return [
  'GET' => [
    '/(?:$|home)/?' => 'Home@index',
    '/about/?' => 'About@index',

    '/products/?($|[0-9])+/?' => 'Products@index',
    '/products/show/($|[0-9])+/?' => 'Products@show',
    '/products/create/?' => 'Products@create',

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
    '/logout/?' => 'Users@logout',

    '/users/?($|[0-9])+/?' => 'Users@index',
    '/users/edit/($|[0-9])+/?' => 'Users@edit',

    '/users/?show/($|[0-9]+)(?:/([0-9]+))?/' => 'Users@show',

  ],

  'POST' => [
    'login/?' => 'Users@login',
    '/user/store/?' => 'User@store',

    '/products/store/?' => 'Products@store',

    '/users/update/?' => 'Users@update',

    '/contact/?($|[\w]+)/send/?' => 'Contact@sendMessage',
    // '/contact/message/send/?' => 'Contact@sendMessage',
    // '/contact/work/send/?' => 'Contact@workSend',
    
  ],
];
