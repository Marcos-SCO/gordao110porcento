<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Config\Config;

class Posts extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Post');
    }

    public function index()
    {
        View::renderTemplate('posts/index.html', [
            'title' => 'Posts - Açougue a 110%'
        ]);
    }

    public function create()
    {
        $this->isLogin();

        if (isset($_SESSION['submitted'])) {
            unset($_SESSION['submitted']);
        }

        View::renderTemplate('posts/create.html', [
            'title' => 'Criar Post - Açougue a 110%'
        ]);
    }

    public function store()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['submitted'])) {
            $result = $this->model->getPostData();
            $data = $result[0];
            $error = $result[1];

            // Validate data
            if ($error['error'] != true) {
                $fullPath = $this->imgCreateHandler('posts');
                $this->moveUpload($fullPath);

                if ($this->model->addPost($data)) {
                    flash('post_message', 'Post adicionado');
                    dump('Envio deu bom');
                    $_SESSION['submitted'] = true;
                } else {
                    die('Algo deu errado..');
                }
            } else {
                View::renderTemplate('posts/create.html', [
                    'title' => 'Criar Post - Açougue a 110%',
                    'data' => $data,
                    'error' => $error
                ]);
            }
        }
    }

    public function show()
    {
        $this->isLogin();

        View::renderTemplate('posts/show.html', [
            'title' => 'Show Post - Açougue a 110%'
        ]);
    }

    public function edit($id)
    {
        $this->isLogin();

        View::renderTemplate('posts/edit.html', [
            'title' => "Edit Post {$id}"
        ]);
    }

    public function update()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->model->getPostData();
            $this->model->updatePost($data);
        }
    }

    public function destroy($id)
    {
        //
    }
}
