<?php

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;

use App\Request\ImageRequest;
use App\Request\PostRequest;
use App\Request\RequestData;

use App\Traits\GeneralImagesHandlerTrait;

use Core\Controller;
use Core\View;

class Posts extends Controller
{
    use GeneralImagesHandlerTrait;

    public $model;
    public $imagesHandler;
    public $dataPage = 'posts';

    public function __construct()
    {
        $this->model = $this->model('Post');
        $this->imagesHandler = new ImagesHandler();
    }

    public function index($requestData, $flash = false)
    {
        removeSubmittedFromSession();

        $table = 'posts';

        $pageId = isset($requestData['posts']) && !empty($requestData['posts']) ? $requestData['posts'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 8, '', $orderOption = 'ORDER BY id DESC');

        View::render('posts/index.php', [
            'dataPage' => $this->dataPage,
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
        $this->ifNotAuthRedirect();

        removeSubmittedFromSession();

        View::render('posts/create.php', [
            'controller' => 'Posts',
            'dataPage' => 'posts/create',
            'title' => 'Criar Post ',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->ifNotAuthRedirect();

        if (isSubmittedInSession()) return redirect('posts');

        $requestedData = array_merge(
            PostRequest::postFieldsValidation(),
            ImageRequest::validateImageParams(),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = RequestData::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->create($data, $errorData);
        }

        $addedPost = $this->model->addPost($data);

        $lastInsertedPostId = $this->model->lastId();

        if (!$addedPost) die('Something went wrong when adding the post...');

        $this->moveUploadImageFolder('posts', $data, $lastInsertedPostId);

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
        $this->ifNotAuthRedirect();

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

    public function update()
    {
        $this->ifNotAuthRedirect();

        $id = indexParamExistsOrDefault(PostRequest::getPostData(), 'id');

        if (isSubmittedInSession()) return redirect('posts/show/' . $id);

        $requestedData = array_merge(
            PostRequest::postFieldsValidation(),
            ImageRequest::validateImageParams(),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');
        if ($id) $data['id'] = $id;

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = RequestData::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->edit(['edit' => $id, 'error' => $errorData]);
        }

        $data = $this->moveUploadImageFolder('posts', $data);

        $this->model->updatePost($data);

        flash('post_message', 'Post Atualizado');

        addSubmittedToSession();

        return redirect('posts/edit/' . $id);
    }

    public function destroy()
    {
        if (isSubmittedInSession()) return redirect('posts');

        $id = indexParamExistsOrDefault(PostRequest::getPostData(), 'id');

        $this->model->deletePost('posts', ['id' => $id]);

        $this->imagesHandler->deleteFolder('posts', $id);

        addSubmittedToSession();

        flash('post_message', 'Post deletado com sucesso!');

        redirect('posts');
    }
}
