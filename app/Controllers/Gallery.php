<?php

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;

use App\Request\GalleryRequest;
use App\Request\ImageRequest;

use App\Traits\GeneralImagesHandlerTrait;

use Core\Controller;
use Core\View;

class Gallery extends Controller
{
    use GeneralImagesHandlerTrait;

    public $model;
    public $imagesHandler;
    public $dataPage = 'gallery';

    public function __construct()
    {
        $this->model = $this->model('Gallery');
        $this->imagesHandler = new ImagesHandler();
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
            'dataPage' => 'gallery/create',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->ifNotAuthRedirect();

        if (isSubmittedInSession()) return redirect('gallery');

        $requestedData = array_merge(
            GalleryRequest::galleryFieldsValidation(),
            ImageRequest::validateImageParams(),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = GalleryRequest::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->create($data, $errorData);
        }

        $addedImg = $this->model->addImg($data);

        if (!$addedImg) die('Something get wrong when adding a img...');

        $lastInsertedPostId = $this->model->lastId();

        $this->moveUploadImageFolder('gallery', $data, $lastInsertedPostId);

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

        $id = indexParamExistsOrDefault(GalleryRequest::getPostData(), 'id');

        $requestedData = array_merge(
            GalleryRequest::galleryFieldsValidation(),
            ImageRequest::validateImageParams(),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');
        if ($id) $data['id'] = $id;

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        if (isSubmittedInSession()) return redirect('gallery');

        $getFirstErrorSign = GalleryRequest::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->edit(['edit' => $id, 'error' => $errorData]);
        }

        $data = $this->moveUploadImageFolder('gallery', $data);

        $this->model->updateImg($data);

        flash('post_message', 'Imagem foi atualizada com sucesso!');

        return redirect('gallery/edit/' . $id);
    }

    public function destroy()
    {
        if (isSubmittedInSession()) return redirect('gallery');

        $id = indexParamExistsOrDefault(GalleryRequest::getPostData(), 'id');

        $this->model->deletePost('gallery', ['id' => $id]);

        $this->imagesHandler->deleteFolder('gallery', $id);

        flash('post_message', 'Item da galeria deletado com sucesso!');

        addSubmittedToSession();

        redirect('gallery');
    }
}
