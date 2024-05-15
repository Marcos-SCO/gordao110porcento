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

    public function index($requestData, $flash = false)
    {
        $table = 'posts';

        $pageId = isset($requestData['posts']) && !empty($requestData['posts']) ? $requestData['posts'] : 1;

        $results = $this->pagination($table, $pageId, $limit = 8, '', $orderOption = 'ORDER BY id DESC');

        View::render('posts/index.php', [
            'title' => 'Posts',
            'controller' => 'Posts',
            'posts' => $results[4],
            'flash' => $flash,
            'path' => 'posts',
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

        if (isset($_SESSION['submitted'])) {
            unset($_SESSION['submitted']);
        }

        View::render('posts/create.php', [
            'controller' => 'Posts',
            'title' => 'Criar Post ',
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

        if ($submittedPostData) {
            return redirect('posts');
        }

        $result = $this->getPostData();
        $data = $result[0];
        $error = $result[1];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) return $this->create($data, $error);

        $fullPath = $this->imgCreateHandler('posts');
        $this->moveUpload($fullPath);

        $addedPost = $this->model->addPost($data);

        if (!$addedPost) die('Something went wrong when adding the post...');

        $_SESSION['submitted'] = true;
        $flash = flash('post_message', 'Post adicionado');
        $id = $this->model->lastId();

        return $this->show($id, $flash);
    }

    public function show($requestData, array $flash = null)
    {
        $pageId = isset($requestData['show']) && !empty($requestData['show']) ? $requestData['show'] : 1;

        $data = $this->model->getAllFrom('posts', $pageId);

        $user = $this->model->getAllFrom('users', $data->user_id);

        return View::render('posts/show.php', [
            'dataPage' => 'posts/show',
            'title' => $data->title,
            'data' => $data,
            'user' => $user,
            'flash' => $flash
        ]);
    }

    public function edit($id, $error = false)
    {
        $this->isLogin();
        $data = $this->model->getAllFrom('posts', $id);

        View::render('posts/edit.php', [
            'controller' => 'Posts',
            'title' => "Editar - $data->title",
            'data' => $data,
            'error' => $error
        ]);
    }

    public function update()
    {
        $this->isLogin();

        $submittedPostData = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$submittedPostData) {
            return redirect('posts');
        }

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

        if ($isEmptyImg) $data[0]['img'] = $postImg;

        if (!$isEmptyImg) {
            $fullPath = $this->imgFullPath('posts', $id, $img);
            $this->moveUpload($fullPath);
            $data['img'] = explode('/', $fullPath);
        }

        $this->model->updatePost($data[0]);
        $flash = flash('post_message', 'Post Atualizado');

        return $this->show($id, $flash);
    }

    public function getPostData()
    {
        $notAllowedTags = array('<script>', '<a>');
        $body = isset($_POST['body']) ? trim($_POST['body']) : '';
        $body = trim(str_replace($notAllowedTags, '', $body));

        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $id = isset($_POST['id']) ? trim($_POST['id']) : '';

        $title = isset($_POST['title']) ? trim($_POST['title']) : '';

        $img = isset($_FILES['img']) ? $_FILES['img'] : null;

        $postImg = isset($_POST['img']) ? $_POST['img'] : '';

        $userId = isset($_SESSION['user_id'])
            ? $_SESSION['user_id'] : '';

        $titleError = isset($_POST['title_error']) ? trim($_POST['title_error']) : '';

        $bodyError = isset($_POST['body_error']) ? trim($_POST['body_error']) : '';

        $imgPathError = isset($_POST['img_error']) ? trim($_POST['img_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'title' => $title,
            'body' => $body,
            'img' => $img['name'],
            'post_img' => $postImg,
            'user_id' => $userId,
        ];

        $error = [
            'title_error' => $titleError,
            'body_error' => $bodyError,
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

        if (empty($data['title'])) {
            $error['title_error'] = "Coloque o título.";
            $error['error'] = true;
        }
        if (empty($data['body'])) {
            $error['body_error'] = "Preencha o campo de texto.";
            $error['error'] = true;
        }

        return [$data, $error];
    }
}
