<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;
use App\Classes\RequestData;

use Core\Controller;
use Core\View;

class Gallery extends Controller
{
    public $model;
    public $imagesHandler;
    public $dataPage = 'gallery';

    public function __construct()
    {
        $this->model = $this->model('Gallery');
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

        if (empty($data['img_title'])) {
            $errors['img_title_error'] = "Coloque uma descrição para imagem";
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
            $this->imagesHandler->imgFolderCreate('gallery', $id, $imgName);

        $this->imagesHandler->moveUpload($fullPath);

        $data['img_name'] = $imgName;

        return $data;
    }

    public function index($requestData = 1, $flash = false)
    {
        removeSubmittedFromSession();

        $table = 'gallery';

        $pageId = isset($requestData['gallery']) && !empty($requestData['gallery']) ? $requestData['gallery'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 8, '', $orderOption = 'ORDER BY id DESC');

        View::render('gallery/index.php', [
            'dataPage' => $this->dataPage,
            'title' => 'Galeria de imagens',
            'gallery' => $results['tableResults'],
            'flash' => $flash,
            'path' => $table,
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

        if (isset($_SESSION['submitted'])) unset($_SESSION['submitted']);

        View::render('gallery/create.php', [
            'title' => 'Enviar uma nova foto para galeria',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->ifNotAuthRedirect();

        if (isSubmittedInSession()) return redirect('gallery');

        $requestedData = $this->getRequestData();

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->create($data, $errorData);

        $addedImg = $this->model->addImg($data);

        if (!$addedImg) die('Something get wrong when adding a img...');

        $lastInsertedPostId = $this->model->lastId();

        $this->moveUploadImageFolder($data, $lastInsertedPostId);

        addSubmittedToSession();

        flash('post_message', 'Imagem adicionada com sucesso');

        return redirect('gallery');
    }

    public function show($id, array $flash = null)
    {
        $table = 'gallery';
        $results = Pagination::handler($table, $id, $limit = 1, '', $orderOption = 'ORDER BY id DESC');

        $haveResults = $this->model->rowCount() > 0;

        if (!$haveResults) {
            // if id is not encountered
            throw new \Exception("$id was not found");
        }

        $user = $this->model->getAllFrom('users', $results[4][0]->user_id);

        $userImgTittle = $results['tableResults'][0]->img_title;

        return View::render('gallery/show.php', [
            'title' => $userImgTittle,
            'pageId' => $id,
            'data' => $results['tableResults'][0],
            'img_title' => $userImgTittle,
            'user' => $user,
            'flash' => $flash,
            'path' => 'gallery/show',
            'page' => $id,
            'prev' => $results['prev'],
            'next' => $results['next'],
            'totalResults' => $results['totalResults'],
            'totalPages' => $results['totalPages'],
        ]);
    }

    public function edit($requestData)
    {
        $this->ifNotAuthRedirect();

        removeSubmittedFromSession();

        $id = indexParamExistsOrDefault($requestData, 'edit');

        $errors = indexParamExistsOrDefault($requestData, 'error');

        $data = $this->model->getAllFrom('gallery', $id);

        View::render('gallery/edit.php', [
            'title' => "Editar - $data->img_title",
            'data' => $data,
            'error' => $errors
        ]);
    }

    public function update()
    {
        $this->ifNotAuthRedirect();

        $requestResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($requestResultData, 'data');

        $errorData = indexParamExistsOrDefault($requestResultData, 'errorData');

        $id = $data['id'];

        if (isSubmittedInSession()) return redirect('gallery');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->edit(['edit' => $id, 'error' => $errorData]);

        $data = $this->moveUploadImageFolder($data);

        $this->model->updateImg($data);

        flash('post_message', 'Imagem foi atualizada com sucesso!');

        return redirect('gallery/edit/' . $id);
    }

    public function destroy()
    {
        if (isSubmittedInSession()) return redirect('gallery');

        $requestResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($requestResultData, 'data');

        $id = $data['id'];

        $this->model->deletePost('gallery', ['id' => $id]);

        $this->imagesHandler->deleteFolder('gallery', $id);

        flash('post_message', 'Item da galeria deletado com sucesso!');

        addSubmittedToSession();

        redirect('gallery');
    }
}
