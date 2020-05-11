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

        View::renderTemplate('posts/create.html', [
            'title' => 'Criar Post - Açougue a 110%'
        ]);
    }

    public function store()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->model->getPostData();

            // Validate data
            $errors = false;

            if (isset($_FILES)) {
                $imgFullPath = $this->model->imgHandler('posts');
            }
            if ($errors != true) {
                if ($this->model->addPost($data)) {
                    flash('post_message', 'Post adicionado');

                    dump('Envio deu bom');
                } else {
                    die('Algo deu errado..');
                }
            } else {
                View::renderTemplate('posts/create.html', [
                    'title' => 'Criar Post - Açougue a 110%',
                    'data' => $data,
                    'imgFullPath' => $imgFullPath
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
