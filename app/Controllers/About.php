<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

class About extends Controller
{
    public $model;
    public $dataPage = 'about';

    public function __construct()
    {
        $this->model = $this->model('About');
    }

    public function index()
    {
        $posts = $this->model->getPosts();
        $categories = $this->model->getCategories();
        $hamburgers = $this->model->getProducts(1);
        $pizzas = $this->model->getProducts(2);

        View::render('about/index.php', [
            'dataPage' => $this->dataPage,
            'controller' => 'About',
            'title' => 'Sobre',
            'hamburgers' => $hamburgers,
            'pizzas' => $pizzas,
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }
}
