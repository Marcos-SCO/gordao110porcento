<?php

return [
  'GET' => [
    '/(?:$|home)/?' => 'Home@index',
    '/about/?' => 'About@index',

    '/products/?($|[0-9])+/?' => 'Products@index',
    '/products/show/($|[0-9])+/?' => 'Products@show',
    '/products/edit/($|[0-9])+/?' => 'Products@edit',

    '/products/create/?' => 'Products@create',

    '/gallery/?($|[0-9])+/?' => 'Gallery@index',
    '/gallery/create/?' => 'Gallery@create',
    '/gallery/edit/($|[0-9])+/?' => 'Gallery@edit',
    
    '/posts/?($|[0-9])+/?' => 'Posts@index',
    '/posts/?show/($|[0-9])+/?' => 'Posts@show',
    '/posts/create/?' => 'Posts@create',
    '/posts/edit/($|[0-9])+/?' => 'Posts@edit',
    
    '/categories/?($|[0-9])+/?' => 'Categories@index',
    '/categories/create/?' => 'Categories@create',
    '/categories/edit/($|[0-9])+/?' => 'Categories@edit',
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

    '/posts/store/?' => 'Posts@store',
    '/posts/update/?' => 'Posts@update',
    '/posts/delete/?' => 'Posts@destroy',

    '/products/store/?' => 'Products@store',
    '/products/update/?' => 'Products@update',
    '/products/delete/?' => 'Products@destroy',
    
    '/categories/store/?' => 'Categories@store',
    '/categories/update/?' => 'Categories@update',
    '/categories/delete/?' => 'Categories@destroy',

    '/gallery/store/?' => 'Gallery@store',
    '/gallery/update/?' => 'Gallery@update',
    '/gallery/delete/?' => 'Gallery@destroy',

    '/users/update/?' => 'Users@update',

    '/contact/?($|[\w]+)/send/?' => 'Contact@sendMessage',
    
  ],
];
