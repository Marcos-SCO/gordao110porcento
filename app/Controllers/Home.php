<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

class Home extends Controller
{
    public $model;
    public $dataPage = 'home';

    public function __construct()
    {
        $this->model = $this->model('Home');
    }

    public function index()
    {
        $posts = $this->model->getPosts();
        $categories = $this->model->getCategories();
        $hamburgers = $this->model->getProducts(1);
        $pizzas = $this->model->getProducts(2);

        View::render('home/index.php', [
            'dataPage' => $this->dataPage,
            'controller' => 'Home',
            'title' => 'Gordão a 110%',
            'hamburgers' => $hamburgers,
            'pizzas' => $pizzas,
            'categories' => $categories,
            'posts' => $posts,
        ]);
    }
}
