<?php

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Request\ImageRequest;
use App\Request\ProductRequest;
use App\Request\RequestData;
use App\Request\SlugsRequest;
use App\Traits\ProductsImagesHandlerTrait;
use App\Traits\SlugsTrait;
use Core\Controller;
use Core\Model;
use Core\View;

class Products extends Controller
{
    use ProductsImagesHandlerTrait;
    use SlugsTrait;

    public $model;
    public $imagesHandler;
    public $dataPage = 'products';

    public function __construct()
    {
        $this->model = $this->model('Product');
        $this->imagesHandler = new ImagesHandler();
    }

    public function index($requestData)
    {
        removeSubmittedFromSession();

        $table = 'products';

        $pageId = isset($requestData['products']) && !empty($requestData['products']) ? $requestData['products'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 12, '', $orderOption = 'ORDER BY id DESC');

        $flash = indexParamExistsOrDefault($requestData, 'flash');

        // Category elements from table categories
        $categoryElements = ProductCategory::getCategories();

        View::render('products/index.php', [
            'title' => "Ofertas | Página $pageId",
            'dataPage' => $this->dataPage,
            'categoryElements' => $categoryElements,
            'products' => $results['tableResults'],
            'flash' => $flash,
            'path' => "products",
            'pageId' => $pageId,
            'data' => $results,
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

        $categories = $this->model->getCategories();

        View::render('products/create.php', [
            'title' => 'Adicione mais produtos',
            'dataPage' => 'products/create',
            'data' => $data,
            'categories' => $categories,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->ifNotAuthRedirect();

        if (isSubmittedInSession()) return redirect('products');

        $requestedData = array_merge(
            ProductRequest::productFieldsValidation(),
            ImageRequest::validateImageParams(),
            SlugsRequest::slugExistenceValidation('products', false, 'produto', [
                'slugField' => 'product_slug',
                'slugFieldError' => 'product_slug_error'
            ]),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = RequestData::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->create($data, $errorData);
        }

        $this->visitingUserRedirect('products');

        // Create a folder in products
        $imageDynamicPath = $this->imagesHandler->getNewImgDynamicPath('products', $data['product_id_category']);

        $this->imagesHandler->moveUpload($imageDynamicPath);

        $addedProduct = $this->model->addProduct($data);

        if (!$addedProduct) {
            die('Something went wrong when adding the product...');
        }

        addSubmittedToSession();

        // $productLastId = $this->model->lastId();

        flash('post_message', 'Produto adicionado com sucesso');

        return redirect('products');
    }

    public function show($requestData)
    {
        $productSlug =
            indexParamExistsOrDefault($requestData, 'product');

        // $productId = indexParamExistsOrDefault($requestData, 'show');

        $data = $this->model->getAllFrom('products', "$productSlug", 'slug');

        // $categories = $this->model->getCategories();

        $user = $this->model->getAllFrom('users', $data->user_id);

        $category = self::getSlugById('product_categories', $data->id_category, 'slug')[0];

        removeSubmittedFromSession();

        return View::render('products/show.php', [
            'title' => $data->product_name,
            'product_name' => $data->product_name,
            'data' => $data,
            'user' => $user,
            'category' => $category,
            // 'categories' => $categories,
        ]);
    }

    public function edit($requestData)
    {
        $this->ifNotAuthRedirect();

        removeSubmittedFromSession();

        $productId = indexParamExistsOrDefault($requestData, 'edit');

        $errors = indexParamExistsOrDefault($requestData, 'error');

        $data = $this->model->getAllFrom('products', $productId);

        $categories = $this->model->getCategories();

        View::render('products/edit.php', [
            'title' => "Editar - $data->product_name",
            'data' => $data,
            'categories' => $categories,
            'product_id_category' => $data->id_category,
            'error' => $errors,
        ]);
    }

    public function update()
    {
        $this->ifNotAuthRedirect();

        $post = ProductRequest::getPostData();
        $id = indexParamExistsOrDefault($post, 'id');
        $postImg = indexParamExistsOrDefault($post, 'img');

        if (isSubmittedInSession()) return redirect('products/show/' . $id);

        $requestedData = array_merge(
            ProductRequest::productFieldsValidation(),
            ImageRequest::validateImageParams(),
            SlugsRequest::slugExistenceValidation('products', "AND id != $id", 'produtos', [
                'slugField' => 'product_slug',
                'slugFieldError' => 'product_slug_error'
            ]),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        if ($id) $data['id'] = $id;
        if ($postImg || $postImg == '0') $data['post_img'] = $postImg;

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = RequestData::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->edit(['edit' => $id, 'error' => $errorData]);
        }

        $this->visitingUserRedirect('products/edit/'. $id);

        $data = $this->moveUploadImageFolder($data);

        $this->model->updateProduct($data);

        addSubmittedToSession();

        flash('post_message', 'Produto foi atualizado com sucesso!');

        // return redirect('products/show/' . $id);
        return redirect('products/edit/' . $id);
    }

    // Delete function for controllers
    public function destroy()
    {
        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest || isSubmittedInSession()) {

            return redirect('products');
        }

        $id = indexParamExistsOrDefault(RequestData::getPostData(), 'id');

        $productIdCategory = indexParamExistsOrDefault(RequestData::getPostData(), 'product_id_category');

        if (!$id) die('No id was provided');
        if (!$productIdCategory) die('No product_id_category was provided');

        $this->visitingUserRedirect('products/edit/'. $id);

        $this->model->deleteProduct('products', ['id' => $id]);

        $this->imagesHandler->deleteFolder('products', $id, $productIdCategory);

        flash('post_message', 'Produto deletado com sucesso!');

        redirect('products');
    }
}
