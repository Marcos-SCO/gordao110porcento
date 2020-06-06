<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

class About extends Controller
{
    public function __construct()
    {
        $this->model = $this->model('About');
    }

    public function index()
    {
        $posts = $this->model->getPosts();
        $categories = $this->model->getCategories();
        $hamburguers = $this->model->getProducts(1);
        $pizzas = $this->model->getProducts(2);

        View::render('about/index.php', [
            'title' => 'Gordão a 110% - Sobre',
            'hamburguers' => $hamburguers,
            'pizzas' => $pizzas,
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }

    protected function create()
    {
    }

    public function store($request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update($table, $data, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
