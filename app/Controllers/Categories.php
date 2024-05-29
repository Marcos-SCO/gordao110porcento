<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;
use App\Classes\RequestData;

use Core\Controller;
use Core\View;

class Categories extends Controller
{
    public $model;
    public $imagesHandler;

    public function __construct()
    {
        $this->model = $this->model('Category');
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

        if (empty($data['category_name'])) {
            $errors['category_name_error'] = "Coloque o nome da categoria";
            $errors['error'] = true;
        }

        if (empty($data['category_description'])) {
            $errors['category_description_error'] = "Coloque uma descrição para imagem";
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
            $this->imagesHandler->imgFolderCreate('categories', $id, $imgName);

        $this->imagesHandler->moveUpload($fullPath);

        $data['img_name'] = $imgName;

        return $data;
    }

    public function index($requestData = 1, $flash = false)
    {
        $table = 'categories';

        $pageId = isset($requestData['categories']) && !empty($requestData['categories']) ? $requestData['categories'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 3, '', $orderOption = 'ORDER BY id DESC');

        // Category elements from table categories
        $categoryElements = $this->model->customQuery('SELECT id, category_name FROM categories', null, 1);

        View::render('categories/index.php', [
            'title' => 'Todas Categorias',
            'categoryElements' => $categoryElements,
            'categories' => $results['tableResults'],
            'flash' => $flash,
            'path' => 'categories',
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

        View::render('categories/create.php', [
            'title' => 'Adicione mais uma categoria',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->isLogin();

        if (isSubmittedInSession()) return redirect('categories');

        $requestedData = $this->getRequestData();

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->create($data, $errorData);

        $addedCategory = $this->model->addCategory($data);

        if (!$addedCategory) die('Something went wrong while creating a category');

        $lastInsertedPostId = $this->model->lastId();

        $this->moveUploadImageFolder($data, $lastInsertedPostId);

        addSubmittedToSession();

        flash('post_message', 'Categoria adicionada com sucesso!');

        return redirect('categories');
    }

    public function show($requestData)
    {
        removeSubmittedFromSession();

        $categoryId =
            indexParamExistsOrDefault($requestData, 'show', 1);

        $lastKey = array_key_last($requestData);

        $pageId = !($lastKey == 'show') ? end($requestData) : 1;

        $urlPath = "categories/show/$categoryId";

        // get category fata
        $data = $this->model->getAllFrom('categories', $categoryId);
        // get user data
        $user = $this->model->getAllFrom('users', $data->user_id);

        $productsTable = 'products';

        $results = Pagination::handler($productsTable, $pageId, $limit = 4, ['id_category', $categoryId], $orderOption = 'ORDER BY id DESC');

        $categoryElements = $this->model->customQuery('SELECT id, category_name FROM categories', null, 1);

        // Display results
        return View::render('categories/show.php', [
            'title' => $data->category_name . ' | Página ' . $pageId,
            'category_description' => $data->category_description,
            'categoryElements' => $categoryElements,
            'pageId' => $pageId,
            'data' => $data,
            'user' => $user,
            'page' => $pageId,
            'path' => $urlPath,
            'products' => $results['tableResults'],
            'prev' => $results['prev'],
            'next' => $results['next'],
            'totalResults' => $results['totalResults'],
            'totalPages' => $results['totalPages'],
        ]);
    }

    public function edit($requestData)
    {
        $this->isLogin();

        removeSubmittedFromSession();

        $id = indexParamExistsOrDefault($requestData, 'edit');

        $errors = indexParamExistsOrDefault($requestData, 'error');

        $data = $this->model->getAllFrom('categories', $id);

        View::render('categories/edit.php', [
            'title' => "Editar - $data->category_name",
            'data' => $data,
            'error' => $errors
        ]);
    }

    public function update()
    {
        $this->isLogin();

        $requestResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($requestResultData, 'data');

        $errorData = indexParamExistsOrDefault($requestResultData, 'errorData');

        $id = $data['id'];

        if (isSubmittedInSession()) return redirect('categories');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->edit(['edit' => $id, 'error' => $errorData]);

        $data = $this->moveUploadImageFolder($data);

        $this->model->updateCategory($data);

        flash('post_message', 'Categoria foi atualizada com sucesso!');

        return redirect('categories');
    }

    // Delete function for controllers
    public function destroy($id)
    {
        if (isSubmittedInSession()) return redirect('categories');

        $requestResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($requestResultData, 'data');

        $id = $data['id'];

        $this->model->deletePost('categories', ['id' => $id]);

        $this->imagesHandler->deleteFolder('categories', $id);
        $this->imagesHandler->deleteFolder('products', false, $id, true);

        flash('post_message', 'Item de categoria deletado com sucesso!');

        addSubmittedToSession();

        redirect('categories');
    }
}
