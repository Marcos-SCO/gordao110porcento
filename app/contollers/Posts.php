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
                    $_SESSION['submitted'] = true;
                    $flash = flash('post_message', 'Post adicionado');
                    $id = $this->model->lastId();
                    return $this->show($id, $flash);
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

    public function show($id, $flash = null)
    {
        $data = $this->model->getPost($id);
        $user = $this->model->getUser($id);
        View::renderTemplate('posts/show.html', [
            'title' => $data->title,
            'data' => $data,
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $this->isLogin();
        $data = $this->model->getPost($id);

        View::renderTemplate('posts/edit.html', [
            'title' => "Editar - $data->title",
            'data' => $data
        ]);
    }

    public function update()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data[0] = $this->model->getPostData();
            $id = $data[0][0]['id'];
            $postImg = $this->model->getImg($id);
            $img = $data[0][0]['img'];

            if ($img != $postImg) {
                $fullPath = $this->imgFullPath('posts', $id, $img);
                $this->moveUpload($fullPath);
                $data['img'] = explode('/',$fullPath);
            }
            if ($this->model->updatePost($data[0][0])) {
                $flash = flash('post_message', 'Post Atualizado');
                return $this->show($id, $flash);
            }
        }
    }

    public function destroy($id)
    {
        //
    }
}
