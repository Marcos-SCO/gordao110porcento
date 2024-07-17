<?php

return [
  'GET' => [
    '/(?:$|home)/?' => 'Home@index',
    '/about/?' => 'About@index',

    '/products/?($|[0-9])+/?' => 'Products@index',
    
    '/product/([a-z0-9-]+)/?' => 'Products@show',
    '/products/edit/($|[0-9])+/?' => 'Products@edit',

    '/products/create/?' => 'Products@create',

    '/gallery/?($|[0-9])+/?' => 'Gallery@index',
    '/gallery/create/?' => 'Gallery@create',
    '/gallery/edit/($|[0-9])+/?' => 'Gallery@edit',
    
    '/posts(?:/page)?/(\d+)?/?' => 'Posts@index',
    // '/posts/?show/($|[0-9])+/?' => 'Posts@show',
    '/post/([a-z0-9-]+)/?' => 'Posts@show',
    '/posts/create/?' => 'Posts@create',
    '/posts/edit/($|[0-9])+/?' => 'Posts@edit',

    '/categories/?($|[0-9])+/?' => 'ProductCategories@index',
    '/categories/create/?' => 'ProductCategories@create',
    '/categories/edit/($|[0-9])+/?' => 'ProductCategories@edit',

    '/category/([a-z0-9-]+)(?:/page/(\d+))?/?' => 'ProductCategories@show',
    
    '/contact/?($|[\w]+)/?' => 'Contact@index',
    
    '/login/?' => 'UsersAuth@login',
    '/logout/?' => 'UsersAuth@logout',
    
    '/users/?($|[0-9])+/?' => 'Users@index',
    '/users/edit/($|[0-9])+/?' => 'Users@edit',
    '/users/create/?' => 'Users@create',

    // '/users/?show/($|[0-9]+)(?:/([0-9]+))?/' => 'Users@show',
    '/user/($|[a-z0-9-_]+)(?:/page/(\d+))?/?' => 'Users@show',

  ],

  'POST' => [
    '/login/?' => 'UsersAuth@login',

    '/users/store/?' => 'Users@store',
    '/users/update/?' => 'Users@update',

    '/users/status/($|[0-9]+)/($|[0-9]+)/?' => 'Users@status',

    '/posts/store/?' => 'Posts@store',
    '/posts/update/?' => 'Posts@update',
    '/posts/delete/?' => 'Posts@destroy',

    '/products/store/?' => 'Products@store',
    '/products/update/?' => 'Products@update',
    '/products/delete/?' => 'Products@destroy',
    
    '/categories/store/?' => 'ProductCategories@store',
    '/categories/update/?' => 'ProductCategories@update',
    '/categories/delete/?' => 'ProductCategories@destroy',

    '/gallery/store/?' => 'Gallery@store',
    '/gallery/update/?' => 'Gallery@update',
    '/gallery/delete/?' => 'Gallery@destroy',

    '/contact/?($|[\w]+)/send/?' => 'Contact@sendMessage',
    
  ],
];
