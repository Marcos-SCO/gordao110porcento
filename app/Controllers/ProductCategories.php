<?php

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;

use App\Models\ProductCategory;

use App\Request\CategoryRequest;
use App\Request\ImageRequest;
use App\Request\RequestData;
use App\Request\SlugsRequest;
use App\Traits\GeneralImagesHandlerTrait;

use Core\Controller;
use Core\View;

class ProductCategories extends Controller
{
    use GeneralImagesHandlerTrait;

    public $model;
    public $imagesHandler;
    public $dataPage = 'categories';

    public function __construct()
    {
        $this->model = $this->model('ProductCategory');
        $this->imagesHandler = new ImagesHandler();
    }

    public function index($requestData = 1, $flash = false)
    {
        $table = 'product_categories';

        $pageId = isset($requestData['categories']) && !empty($requestData['categories']) ? $requestData['categories'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 3, '', $orderOption = 'ORDER BY id DESC');

        $categoryElements = ProductCategory::getCategories();

        View::render('categories/index.php', [
            'title' => 'Todas Categorias',
            'dataPage' => $this->dataPage,
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

    public function show($requestData)
    {
        removeSubmittedFromSession();

        $categorySlug =
            indexParamExistsOrDefault($requestData, 'category', 1);

        $lastKey = array_key_last($requestData);
          
        $pageId = indexParamExistsOrDefault($requestData, 'page', 1);
        
        $urlPath = "category/$categorySlug/page";
        
        // get category fata
        $data = $this->model->getAllFrom('product_categories', "$categorySlug", 'slug');
        
        // get user data
        $user = $this->model->getAllFrom('users', $data->user_id);
        
        $productsTable = 'products';
        
        $results = Pagination::handler($productsTable, $pageId, $limit = 8, ['id_category', $data->id], $orderOption = 'ORDER BY id DESC');
                
        $categoryElements = ProductCategory::getCategories();

        // Display results
        return View::render('categories/show.php', [
            'title' => $data->category_name . ' | Página ' . $pageId,
            'dataPage' => $this->dataPage,
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

    public function create($data = null, $error = null)
    {
        $this->ifNotAuthRedirect();

        removeSubmittedFromSession();

        View::render('categories/create.php', [
            'title' => 'Adicione mais uma categoria',
            'dataPage' => 'categories/create',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->ifNotAuthRedirect();

        if (isSubmittedInSession()) return redirect('categories');

        $requestedData = array_merge(
            CategoryRequest::categoryFieldsValidation(),
            ImageRequest::validateImageParams(),
            SlugsRequest::slugExistenceValidation('categories', false, 'categorias', [
                'slugField' => 'category_slug',
                'slugFieldError' => 'category_slug_error'
            ]),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = RequestData::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->create($data, $errorData);
        }

        $addedCategory = $this->model->addCategory($data);

        if (!$addedCategory) die('Something went wrong while creating a category');

        $lastInsertedPostId = $this->model->lastId();

        $this->moveUploadImageFolder('categories', $data, $lastInsertedPostId);

        addSubmittedToSession();

        flash('post_message', 'Categoria adicionada com sucesso!');

        return redirect('categories');
    }

    public function edit($requestData)
    {
        $this->ifNotAuthRedirect();

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
        $this->ifNotAuthRedirect();

        if (isSubmittedInSession()) return redirect('categories');

        $postData = RequestData::getPostData();
        $id = indexParamExistsOrDefault($postData, 'id');
        $slug = indexParamExistsOrDefault($postData, 'category_slug');

        $requestedData = array_merge(
            CategoryRequest::categoryFieldsValidation(),
            ImageRequest::validateImageParams(),
            SlugsRequest::slugExistenceValidation('categories', "AND id != $id", 'categorias', [
                'slugField' => 'category_slug',
                'slugFieldError' => 'category_slug_error'
            ]),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        if ($id) $data['id'] = $id;
        if ($slug) $data['category_slug'] = $slug;

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = RequestData::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->edit(['edit' => $id, 'error' => $errorData]);
        }

        $data = $this->moveUploadImageFolder('categories', $data);

        $this->model->updateCategory($data);

        flash('post_message', 'Categoria foi atualizada com sucesso!');

        // return redirect("categories/show/$id/");
        return redirect("categories/edit/$id/");
    }

    // Delete function for controllers
    public function destroy()
    {
        if (isSubmittedInSession()) return redirect('categories');

        $id = indexParamExistsOrDefault(RequestData::getPostData(), 'id');

        $this->model->deletePost('categories', ['id' => $id]);

        $this->imagesHandler->deleteFolder('categories', $id);
        $this->imagesHandler->deleteFolder('products', false, $id, true);

        flash('post_message', 'Item de categoria deletado com sucesso!');

        addSubmittedToSession();

        redirect('categories');
    }
}
