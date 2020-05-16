<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Config\Config;

class Gallery extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Gallery');
    }

    public function index($id = 1, $flash = false)
    {
        $table = 'gallery';
        $results = $this->pagination($table, $id, $limit = 2, $option = 'DESC');
        View::renderTemplate('gallery/index.html', [
            'title' => 'Galeria de imagens',
            'gallery' => $results[4],
            'flash' => $flash,
            'table' => $table,
            'pageId' => $id,
            'prev' => $results[0],
            'next' => $results[1],
            'totalResults' => $results[2],
            'totalPages' => $results[3],
        ]);
    }

    public function create($data = null, $error = null)
    {
        $this->isLogin();

        if (isset($_SESSION['submitted'])) {
            unset($_SESSION['submitted']);
        }

        View::renderTemplate('gallery/create.html', [
            'title' => 'Enviar uma nova foto para galeria',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['submitted'])) {
            $result = $this->getPostData();
            $data = $result[0];
            $error = $result[1];

            // Validate data
            if ($error['error'] != true) {
                $fullPath = $this->imgCreateHandler('gallery');
                $this->moveUpload($fullPath);

                if ($this->model->addImg($data)) {
                    $_SESSION['submitted'] = true;
                    $flash = flash('post_message', 'Imagem adicionada com successo');
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
        $data = $this->model->getAllFrom('gallery', $id);
        $user = $this->model->getAllFrom('users', $data->user_id);
        return View::renderTemplate('gallery/show.html', [
            'img_title' => $data->img_title,
            'data' => $data,
            'user' => $user,
            'flash' => $flash
        ]);
    }

    public function edit($id, $error = false)
    {
        $this->isLogin();
        $data = $this->model->getAllFrom('gallery', $id);

        View::renderTemplate('gallery/edit.html', [
            'title' => "Editar - $data->img_title",
            'data' => $data,
            'error' => $error
        ]);
    }

    public function update()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];

            if ($error['error'] != true) {
                $img = $data[0]['img'];
                $postImg = $data[0]['post_img'];
                if ($img !== "") {
                    $fullPath = $this->imgFullPath('gallery', $id, $img);
                    $this->moveUpload($fullPath);
                    $data['img'] = explode('/', $fullPath);
                } else {
                    $data[0]['img'] = $postImg;
                }

                $this->model->updateImg($data[0]);
                $flash = flash('post_message', 'Imagem foi atualizada com sucesso!');

                return $this->show($id, $flash);
            } else {
                return $this->edit($id, $error);
            }
        }
    }

    public function delete($id)
    {
        $this->model->deletePost('gallery', ['id' => $id]);
        if ($this->model->rowCount() > 0) {
            $this->deleteFolder('posts', $id);
            $flash = flash('register_seccess', 'Imagem foi deletada com sucesso');
            return $this->index(1, $flash);
        }
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $imgDescription = isset($_POST['img_title']) ? trim($_POST['img_title']) : '';
        $img = isset($_FILES['img']) ? $_FILES['img'] : null;
        $postImg = isset($_POST['img']) ? $_POST['img'] : '';
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $imgDescriptionError = isset($_POST['img_title_error']) ? trim($_POST['img_title_error']) : '';
        $imgPathError = isset($_POST['img_error']) ? trim($_POST['img_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'img_title' => $imgDescription,
            'img' => $img['name'],
            'post_img' => $postImg,
            'user_id' => $userId,
        ];

        $error = [
            'img_title_error' => $imgDescription,
            'img_error' => $imgPathError,
            'error' => false
        ];

        if (empty($data['img_title'])) {
            $error['img_title_error'] = "Coloque uma descrição para imagem";
            $error['error'] = true;
        }
        if (isset($_FILES) && $postImg == '') {
            if (empty($data['img'])) {
                $error['img_error'] = "Insira uma imagem";
                $error['error'] = true;
            }
        }

        return [$data, $error];
    }
}
