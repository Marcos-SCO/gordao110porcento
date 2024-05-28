<?php

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;
use App\Classes\RequestData;
use Core\Controller;
use Core\View;

class Posts extends Controller
{
    public $model;
    public $imagesHandler;

    public function __construct()
    {
        $this->model = $this->model('Post');
        $this->imagesHandler = new ImagesHandler();
    }

    public function getRequestData()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$post) return;

        $postImg = indexParamExistsOrDefault($post, 'img', '');
        $isEmptyPostImg = $postImg == "" || $postImg == false;

        $validatedImgRequest =
            $this->imagesHandler->verifySubmittedImgExtension();

        $requestParams = RequestData::getRequestParams();

        $data = indexParamExistsOrDefault($requestParams, 'data');
        $errors = indexParamExistsOrDefault($requestParams, 'errors');

        if (!$isEmptyPostImg) $data['img_name'] = $postImg;

        if ($data['img_files'] && $postImg == '') {

            if (empty($data['img_files'])) {
                $errors['img_error'] = "Insira uma imagem";
                $errors['error'] = true;
            }

            if (!empty($data['img_files'])) {
                $errors['img_error'] = $validatedImgRequest[1];
                $errors['error'] = $validatedImgRequest[0];
            }
        }

        if (empty($data['title'])) {
            $errors['title_error'] = "Coloque o título.";
            $errors['error'] = true;
        }
        if (empty($data['body'])) {
            $errors['body_error'] = "Preencha o campo de texto.";
            $errors['error'] = true;
        }

        return ['data' => $data, 'errorData' => $errors];
    }

    public function moveUploadImageFolder($data, $lastId = false)
    {
        if ($lastId) $data['id'] = $lastId;

        $id = $data['id'];

        $imgFiles = indexParamExistsOrDefault($data, 'img_files');

        $imgName = indexParamExistsOrDefault($imgFiles, 'name');

        $isEmptyImg = $imgName == "";

        if ($isEmptyImg) return $data;

        $fullPath =
            $this->imagesHandler->imgFolderCreate('posts', $id, $imgName);

        $this->imagesHandler->moveUpload($fullPath);

        $data['img_name'] = $imgName;

        return $data;
    }

    public function index($requestData, $flash = false)
    {
        removeSubmittedFromSession();

        $table = 'posts';

        $pageId = isset($requestData['posts']) && !empty($requestData['posts']) ? $requestData['posts'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 8, '', $orderOption = 'ORDER BY id DESC');

        View::render('posts/index.php', [
            'title' => 'Posts',
            'controller' => 'Posts',
            'posts' => $results['tableResults'],
            'flash' => $flash,
            'path' => 'posts',
            'pageId' => $pageId,
            'prev' => $results['prev'],
            'next' => $results['next'],
            'totalResults' => $results['totalResults'],
            'totalPages' => $results['totalPages'],
        ]);
    }

    public function create($data = null, $error = null)
    {
        $this->isLogin();

        removeSubmittedFromSession();

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

        if (isSubmittedInSession()) return redirect('posts');

        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->create($data, $errorData);

        $addedPost = $this->model->addPost($data);

        $lastInsertedPostId = $this->model->lastId();

        if (!$addedPost) die('Something went wrong when adding the post...');

        $this->moveUploadImageFolder($data, $lastInsertedPostId);

        addSubmittedToSession();

        flash('post_message', 'Post adicionado com sucesso');

        return redirect('posts/show/' . $lastInsertedPostId);
    }

    public function show($requestData)
    {
        removeSubmittedFromSession();

        $postId = indexParamExistsOrDefault($requestData, 'show');

        $data = $this->model->getAllFrom('posts', $postId);

        $user = $this->model->getAllFrom('users', $data->user_id);

        return View::render('posts/show.php', [
            'dataPage' => 'posts/show',
            'title' => $data->title,
            'data' => $data,
            'user' => $user,
        ]);
    }

    public function edit($requestData)
    {
        $this->isLogin();

        removeSubmittedFromSession();

        $postId = indexParamExistsOrDefault($requestData, 'edit');

        $errors = indexParamExistsOrDefault($requestData, 'error');

        $data = $this->model->getAllFrom('posts', $postId);

        View::render('posts/edit.php', [
            'controller' => 'Posts',
            'title' => "Editar - $data->title",
            'data' => $data,
            'error' => $errors
        ]);
    }

    public function update($requestData)
    {
        $this->isLogin();

        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $id = $data['id'];

        if (isSubmittedInSession()) return redirect('posts/show/' . $id);

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->edit(['edit' => $id, 'error' => $errorData]);

        $data = $this->moveUploadImageFolder($data);

        $this->model->updatePost($data);

        flash('post_message', 'Post Atualizado');

        addSubmittedToSession();

        return redirect('posts/edit/' . $id);
    }

    public function destroy()
    {
        if (isSubmittedInSession()) return redirect('posts');

        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $id = $data['id'];

        $this->model->deletePost('posts', ['id' => $id]);

        $this->imagesHandler->deleteFolder('posts', $id);

        addSubmittedToSession();

        flash('post_message', 'Post deletado com sucesso!');

        redirect('posts');
    }
}
