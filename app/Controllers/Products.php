<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;
use Core\Controller;
use Core\View;

class Products extends Controller
{
    public $model;
    public $imagesHandler;

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

        $id = indexParamExistsOrDefault($post, 'id');

        $postIdCategory = indexParamExistsOrDefault($post, 'id_category');

        $productName = indexParamExistsOrDefault($post, 'product_name');

        $productDescription = indexParamExistsOrDefault($post, 'product_description');

        $price = verifyValue($post, 'price');

        if ($price) {

            $price = trim(preg_replace("/[^0-9,.]+/i", "", $price));
            $price = str_replace(",", ".", $price);
        }

        $imgFiles = indexParamExistsOrDefault($_FILES, 'img');

        $imgName = indexParamExistsOrDefault($imgFiles, 'name');

        $postImg = isset($_POST['img']) ? $_POST['img'] : '';

        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

        $postIdCategoryError = isset($_POST['id_category_error']) ? trim($_POST['id_category_error']) : '';

        $productNameError = isset($_POST['product_name_error']) ? trim($_POST['product_name_error']) : '';

        $productDescriptionError =
            isset($_POST['product_description_error'])
            ? trim($_POST['product_description_error']) : '';

        $priceError = isset($_POST['price_error']) ? trim($_POST['price_error']) : '';

        $imgPathError = isset($_POST['img_error']) ? trim($_POST['img_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'id_category' => $postIdCategory,
            'product_name' => $productName,
            'product_description' => $productDescription,
            'price' => $price,
            'img_files' => $imgFiles,
            'img_name' => $imgName,
            'post_img' => $postImg,
            'user_id' => $userId,
        ];

        $error = [
            'id_category_error' => $postIdCategoryError,
            'product_name_error' => $productNameError,
            'product_description_error' => $productDescriptionError,
            'price_error' => $priceError,
            'img_error' => $imgPathError,
            'error' => false
        ];

        $validate =
            $this->imagesHandler->verifySubmittedImgExtension();

        if ($imgFiles && $postImg == '') {

            if (empty($data['img_files'])) {
                $error['img_error'] = "Insira uma imagem";
                $error['error'] = true;
            }

            if (!empty($data['img_files'])) {
                $error['img_error'] = $validate[1];
                $error['error'] = $validate[0];
            }
        }

        if (empty($data['id_category'])) {
            $error['id_category_error'] = "Escolha a categoria";
            $error['error'] = true;
        }

        if (empty($data['product_name'])) {
            $error['product_name_error'] = "Coloque o nome do produto";
            $error['error'] = true;
        }

        if (empty($data['product_description'])) {
            $error['product_description_error'] = "Coloque a descrição do produto";
            $error['error'] = true;
        }

        if (isset($data['price'])) {

            if (!$price) {
                $error['price_error'] = "Insira o preço do produto e somente valores monetários.";
                $error['error'] = true;
            }
        }

        return ['data' => $data, 'errorData' => $error];
    }

    public function index($requestData)
    {
        $table = 'products';

        $pageId = isset($requestData['products']) && !empty($requestData['products']) ? $requestData['products'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 12, '', $orderOption = 'ORDER BY id DESC');

        $flash = indexParamExistsOrDefault($requestData, 'flash');

        // Category elements from table categories
        $categoryElements = $this->model->customQuery('SELECT id, category_name FROM categories', null, 1);

        View::render('products/index.php', [
            'title' => "Ofertas | Página $pageId",
            'categoryElements' => $categoryElements,
            'products' => $results['tableResults'],
            'flash' => $flash,
            'path' => "products",
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

        if (isset($_SESSION['submitted'])) {
            unset($_SESSION['submitted']);
        }

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

        $_SESSION['submitted'] = true;

        // $flash = flash('post_message', 'Produto adicionado com sucesso');

        // $id = $this->model->lastId();

        return redirect('products');
    }

    public function show($requestData)
    {
        $productId = indexParamExistsOrDefault($requestData, 'show');

        $flash = indexParamExistsOrDefault($requestData, 'flash');

        $data = $this->model->getAllFrom('products', $productId);

        $categories = $this->model->getCategories();

        $user = $this->model->getAllFrom('users', $data->user_id);

        return View::render('products/show.php', [
            'title' => $data->product_name,
            'product_name' => $data->product_name,
            'data' => $data,
            'user' => $user,
            'categories' => $categories,
            'flash' => $flash
        ]);
    }

    public function edit($requestData)
    {
        $productId = indexParamExistsOrDefault($requestData, 'edit');

        $flash = indexParamExistsOrDefault($requestData, 'flash');

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

    public function update($requestData)
    {
        $this->isLogin();

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';
        if (!$isPostRequest) return;

        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $id = $data['id'];

        $postIdCategory = $data['id_category'];

        $imgFiles = indexParamExistsOrDefault($data, 'img_files');

        $imgName = indexParamExistsOrDefault($imgFiles, 'name');

        $postImg = $data['post_img'];

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->edit(['edit' => $id, 'error' => $errorData]);

        $result = $this->model->getProduct($id, $postIdCategory);
        $resultId = $this->model->getProductId($id);

        if ($result) {

            $isEmptyImg = $imgName == "";

            if ($isEmptyImg) $data['img_name'] = $postImg;

            if (!$isEmptyImg) {

                $fullPath = $this->imagesHandler->imgFullPath('products', $id, $imgName, $postIdCategory);

                $this->imagesHandler->moveUpload($fullPath);

                $data['img_name'] = $imgName;
            }
        }

        if (!$result) {

            // Create a new path
            $fullPath = $this->imagesHandler->imgFullPath('products', $id, $imgName, $postIdCategory);

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
        }

        $this->model->updateProduct($data);

        $flash = flash('post_message', 'Produto foi atualizado com sucesso!');

        return $this->show(['show' => $id, 'flash' => $flash]);
    }

    // Delete function for controllers
    public function destroy()
    {
        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest) {

            redirect('products');
            return;
        }

        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $id = $data['id'];

        $idCategory = $data['id_category'];

        $this->model->deleteProduct('products', ['id' => $id]);

        $this->imagesHandler->deleteFolder('products', $id, $idCategory);

        redirect('products');
    }
}
