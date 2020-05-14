<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Config\Config;

class WorkWith extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Post');
    }

    public function index()
    {
        View::renderTemplate('WorkWith/create.html', [
            'title' => 'Entrar em contato'
        ]);
    }

    public function create($data = null, $error = null)
    {
        $this->isLogin();

        if (isset($_SESSION['submitted'])) {
            unset($_SESSION['submitted']);
        }

        View::renderTemplate('posts/create.html', [
            'title' => 'Criar Post - Açougue a 110%',
            'data' => $data,
            'error' => $error,
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
                return $this->create($data, $error);
            }
        }
    }

    public function show($id, array $flash = null)
    {
        $data = $this->model->getAllFrom('posts', $id);
        $user = $this->model->getAllFrom('users',$data->user_id);
        return View::renderTemplate('posts/show.html', [
            'title' => $data->title,
            'data' => $data,
            'user' => $user,
            'flash' => $flash
        ]);
    }

    public function edit($id, $error = false)
    {
        $this->isLogin();
        $data = $this->model->getAllFrom('posts',$id);

        View::renderTemplate('posts/edit.html', [
            'title' => "Editar - $data->title",
            'data' => $data,
            'error' => $error
        ]);
    }

    public function update()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->model->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];

            if ($error['error'] != true) {
                $img = $data[0]['img'];
                $postImg = $data[0]['post_img'];
                if ($img !== "") {
                    $fullPath = $this->imgFullPath('posts', $id, $img);
                    $this->moveUpload($fullPath);
                    $data['img'] = explode('/', $fullPath);
                } else {
                    $data[0]['img'] = $postImg;
                }

                $this->model->updatePost($data[0]);
                $flash = flash('post_message', 'Post Atualizado');

                return $this->show($id, $flash);
            } else {
                return $this->edit($id, $error);
            }
        }
    }

    public function delete($id)
    {
        $this->model->deletePost('posts', ['id' => $id]);
        if ($this->model->rowCount() > 0) {
            $this->deleteFolder('posts', $id);
            $flash = flash('register_seccess', 'Deletado com sucesso');
            return $this->index(1, $flash);
        }
    }
}
