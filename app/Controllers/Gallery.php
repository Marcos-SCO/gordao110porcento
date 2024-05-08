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

    public function index($paramsArray = 1, $flash = false)
    {
        $table = 'gallery';

        $pageId = isset($paramsArray['gallery']) && !empty($paramsArray['gallery']) ? $paramsArray['gallery'] : 1;

        $results = $this->pagination($table, $pageId, $limit = 8, '', $orderOption = 'ORDER BY id DESC');

        View::render('gallery/index.php', [
            'dataPage' => 'gallery',
            'title' => 'Galeria de imagens',
            'gallery' => $results[4],
            'flash' => $flash,
            'path' => $table,
            'pageId' => $pageId,
            'prev' => $results[0],
            'next' => $results[1],
            'totalResults' => $results[2],
            'totalPages' => $results[3],
        ]);
    }

    public function create($data = null, $error = null)
    {
        $this->isLogin();

        if (isset($_SESSION['submitted'])) unset($_SESSION['submitted']);

        View::render('gallery/create.php', [
            'title' => 'Enviar uma nova foto para galeria',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->isLogin();

        $submittedPostData =
            isset($_SESSION['submitted']) &&
            $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$submittedPostData) return redirect('gallery');

        $result = $this->getPostData();
        $data = $result[0];
        $error = $result[1];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) {
            return $this->create($data, $error);
        }

        $fullPath = $this->imgCreateHandler('gallery');
        $this->moveUpload($fullPath);

        $addedImg = $this->model->addImg($data);

        if (!$addedImg) {
            die('Something get wrong when adding a img...');
            return;
        }

        $_SESSION['submitted'] = true;
        $flash = flash('post_message', 'Imagem adicionada com sucesso');

        $id = $this->model->lastId();
        return $this->index(1, $flash);
    }

    public function show($id, array $flash = null)
    {
        $table = 'gallery';
        $results = $this->pagination($table, $id, $limit = 1, '', $orderOption = 'ORDER BY id DESC');

        $haveResults = $this->model->rowCount() > 0;

        if (!$haveResults) {
            // if id is not encountered
            throw new \Exception("$id was not found");
        }

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

        $submittedPostData = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$submittedPostData) return;

        $data = $this->getPostData();
        $error = $data[1];
        $id = $data[0]['id'];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) {
            return $this->edit($id, $error);
        }


        $img = $data[0]['img'];
        $postImg = $data[0]['post_img'];

        $isEmptyImg = $img == "";

        if ($isEmptyImg) {
            $data[0]['img'] = $postImg;
        }

        if (!$isEmptyImg) {
            $fullPath = $this->imgFullPath('gallery', $id, $img);
            $this->moveUpload($fullPath);

            $data['img'] = explode('/', $fullPath);
        }

        $this->model->updateImg($data[0]);

        $flash = flash('post_message', 'Imagem foi atualizada com sucesso!');

        return $this->index(1, $flash);
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $id = isset($_POST['id']) ? trim($_POST['id']) : '';

        $imgDescription = isset($_POST['img_title']) ? trim($_POST['img_title']) : '';

        $img = isset($_FILES['img']) ? $_FILES['img'] : null;

        $postImg = isset($_POST['img']) ? $_POST['img'] : '';

        $userId = isset($_SESSION['user_id'])
            ? $_SESSION['user_id'] : '';

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
