<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;
use App\Classes\RequestData;

use Core\Controller;
use Core\View;

class Products extends Controller
{
    public $model;
    public $imagesHandler;
    public $dataPage = 'products';

    public function __construct()
    {
        $this->model = $this->model('Product');
        $this->imagesHandler = new ImagesHandler();
    }

    public function getRequestData()
    {
        // Sanitize data
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

        if (empty($data['id_category'])) {
            $errors['id_category_error'] = "Escolha a categoria";
            $errors['error'] = true;
        }

        if (empty($data['product_name'])) {
            $errors['product_name_error'] = "Coloque o nome do produto";
            $errors['error'] = true;
        }

        if (empty($data['product_description'])) {
            $errors['product_description_error'] = "Coloque a descrição do produto";
            $errors['error'] = true;
        }

        if (empty($data['price'])) {
            $errors['price_error'] = "Insira o preço do produto e somente valores monetários.";
            $errors['error'] = true;
        }

        return ['data' => $data, 'errorData' => $errors];
    }

    public function index($requestData)
    {
        if (isset($_SESSION['submitted'])) unset($_SESSION['submitted']);

        $table = 'products';

        $pageId = isset($requestData['products']) && !empty($requestData['products']) ? $requestData['products'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 12, '', $orderOption = 'ORDER BY id DESC');

        $flash = indexParamExistsOrDefault($requestData, 'flash');

        // Category elements from table categories
        $categoryElements = $this->model->customQuery('SELECT id, category_name FROM categories', null, 1);

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
        $this->isLogin();

        if (isset($_SESSION['submitted'])) unset($_SESSION['submitted']);

        $categories = $this->model->getCategories();

        View::render('products/create.php', [
            'title' => 'Adicione mais produtos',
            'data' => $data,
            'categories' => $categories,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->isLogin();

        if (isSubmittedInSession()) return redirect('products');

        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->create($data, $errorData);

        // Create a folder in products
        $imageDynamicPath = $this->imagesHandler->getNewImgDynamicPath('products', $data['id_category']);

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
        $productId = indexParamExistsOrDefault($requestData, 'show');

        $data = $this->model->getAllFrom('products', $productId);

        $categories = $this->model->getCategories();

        $user = $this->model->getAllFrom('users', $data->user_id);

        removeSubmittedFromSession();

        return View::render('products/show.php', [
            'title' => $data->product_name,
            'product_name' => $data->product_name,
            'data' => $data,
            'user' => $user,
            'categories' => $categories,
        ]);
    }

    public function edit($requestData)
    {
        $productId = indexParamExistsOrDefault($requestData, 'edit');

        $errors = indexParamExistsOrDefault($requestData, 'error');

        $this->isLogin();

        $data = $this->model->getAllFrom('products', $productId);

        $categories = $this->model->getCategories();

        View::render('products/edit.php', [
            'title' => "Editar - $data->product_name",
            'data' => $data,
            'categories' => $categories,
            'id_category' => $data->id_category,
            'error' => $errors,
        ]);
    }

    public function moveUploadImageFolder($data)
    {
        $id = $data['id'];
        $postIdCategory = $data['id_category'];

        $result = $this->model->getProduct($id, $postIdCategory);

        $resultId = $this->model->getProductId($id);

        $imgFiles = indexParamExistsOrDefault($data, 'img_files');

        $imgName = indexParamExistsOrDefault($imgFiles, 'name');

        $postImg = $data['post_img'];

        if (!$result) {

            $isEmptyImg = $imgName == "";

            if ($isEmptyImg) $data['img_name'] = $postImg;

            if (!$isEmptyImg) {

                $createdFolderPath =
                    $this->imagesHandler->imgFolderCreate('products', $id, $imgName, $postIdCategory);

                $this->imagesHandler->moveUpload($createdFolderPath);

                $data['img_name'] = $imgName;
            }

            return $data;
        }

        // Create a new path
        $fullPath = $this->imagesHandler->imgFolderCreate('products', $id, $imgName, $postIdCategory);

        $this->imagesHandler->moveUpload($fullPath);

        $data['img'] = explode('/', $fullPath);

        // Get img data
        $img = ($imgName !== '') ? $imgName : $postImg;

        // Copy from the older to new one
        $oldFolderPath = "../public/resources/img/products/category_{$resultId->id_category}/id_$id/$img";

        $newFolderPath = "../public/resources/img/products/category_{$postIdCategory}/id_$id/$img";

        if (file_exists($oldFolderPath)) {

            copy($oldFolderPath, $newFolderPath);
        }

        // Delete the image in the current folder
        $this->imagesHandler->deleteFolder('products', $id, $resultId->id_category);

        $data['img_name'] = $img;

        return $data;
    }

    public function update($requestData)
    {
        $this->isLogin();

        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $id = $data['id'];

        if (isSubmittedInSession()) return redirect('products/show/' . $id);

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->edit(['edit' => $id, 'error' => $errorData]);

        $data = $this->moveUploadImageFolder($data);

        $this->model->updateProduct($data);

        addSubmittedToSession();

        flash('post_message', 'Produto foi atualizado com sucesso!');

        return redirect('products/show/' . $id);
    }

    // Delete function for controllers
    public function destroy()
    {
        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest || isSubmittedInSession()) {

            return redirect('products');
        }

        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $id = $data['id'];

        $idCategory = $data['id_category'];

        $this->model->deleteProduct('products', ['id' => $id]);

        $this->imagesHandler->deleteFolder('products', $id, $idCategory);

        flash('post_message', 'Produto deletado com sucesso!');

        redirect('products');
    }
}
