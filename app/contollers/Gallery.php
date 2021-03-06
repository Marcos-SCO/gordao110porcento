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
        $results = $this->pagination($table, $id, $limit = 8, '', $orderOption = 'ORDER BY id DESC');
        View::render('gallery/index.php', [
            'title' => 'Galeria de imagens',
            'gallery' => $results[4],
            'flash' => $flash,
            'path' => 'gallery/index',
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

        View::render('gallery/create.php', [
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
                    return $this->index(1, $flash);
                } else {
                    die('Algo deu errado..');
                }
            } else {
                return $this->create($data, $error);
            }
        } else {
            redirect('gallery');
        }
    }

    public function show($id, array $flash = null)
    {
        $table = 'gallery';
        $results = $this->pagination($table, $id, $limit = 1, '', $orderOption = 'ORDER BY id DESC');
        if ($this->model->rowCount() > 0) {
            $user = $this->model->getAllFrom('users', $results[4][0]->user_id);

            return View::render('gallery/show.php', [
                'title' =>  $results[4][0]->img_title,
                'pageId' => $id,
                'data' => $results[4][0],
                'img_title' =>  $results[4][0]->img_title,
                'user' => $user,
                'flash' => $flash,
                'path' => 'gallery/show',
                'page' => $id,
                'prev' => $results[0],
                'next' => $results[1],
                'totalResults' => $results[2],
                'totalPages' => $results[3],
            ]);
        } else {
            // if id is not encountered
            throw new \Exception("$id not found");
        }
    }

    public function edit($id, $error = false)
    {
        $this->isLogin();
        $data = $this->model->getAllFrom('gallery', $id);

        View::render('gallery/edit.php', [
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

                return $this->index(1, $flash);
            } else {
                return $this->edit($id, $error);
            }
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
            'img_title_error' => $imgDescriptionError,
            'img_error' => $imgPathError,
            'error' => false
        ];

        $validate = $this->imgValidate();
        if (isset($_FILES['img']) && $postImg == '') {
            if (empty($data['img'])) {
                $error['img_error'] = "Insira uma imagem";
                $error['error'] = true;
            }
            if (!empty($data['img'])) {
                $error['img_error'] = $validate[1];
                $error['error'] = $validate[0];
            }
        } else if ($postImg && !empty($data['img'])) {
            $error['img_error'] = $validate[1];
            $error['error'] = $validate[0];
        }

        if (empty($data['img_title'])) {
            $error['img_title_error'] = "Coloque uma descrição para imagem";
            $error['error'] = true;
        }

        return [$data, $error];
    }
}
