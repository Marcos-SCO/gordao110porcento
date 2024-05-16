<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

class Products extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Product');
    }

    public function index($requestData, $flash = false)
    {
        $table = 'products';

        $pageId = isset($requestData['products']) && !empty($requestData['products']) ? $requestData['products'] : 1;

        $results = $this->pagination($table, $pageId, $limit = 12, '', $orderOption = 'ORDER BY id DESC');

        // Category elements from table categories
        $categoryElements = $this->model->customQuery('SELECT id, category_name FROM categories', null, 1);

        View::render('products/index.php', [
            'title' => "Ofertas | Página $pageId",
            'categoryElements' => $categoryElements,
            'products' => $results[4],
            'flash' => $flash,
            'path' => "products",
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

        // $submittedPostData =
        //     isset($_SESSION['submitted']) &&
        //     $_SERVER['REQUEST_METHOD'] == 'POST';

        // if (!$submittedPostData) {
        //     return redirect('products');
        // }

        $postResultData = $this->getPostData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->create($data, $errorData);

        // Create a folder in products
        $fullPath = $this->imgCreateHandler('products', $data['id_category']);

        $this->moveUpload($fullPath);

        $addedProduct = $this->model->addproduct($data);

        if (!$addedProduct) {
            die('Something went wrong when adding the product...');
        }

        $_SESSION['submitted'] = true;

        $flash = flash('post_message', 'Produto adicionado com successo');
        
        $id = $this->model->lastId();

        return $this->show(['show' => $id, 'flash' => $flash]);
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

    public function edit($id, $error = false)
    {
        $this->isLogin();
        $data = $this->model->getAllFrom('products', $id);
        $categories = $this->model->getCategories();

        View::render('products/edit.php', [
            'title' => "Editar - $data->product_name",
            'data' => $data,
            'categories' => $categories,
            'id_category' => $data->id_category,
            'error' => $error
        ]);
    }

    public function update()
    {
        $this->isLogin();

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest) return;

        $data = $this->getPostData();
        $error = $data[1];
        $id = $data[0]['id'];
        $postIdCategory = $data[0]['id_category'];
        $img = $data[0]['img'];
        $postImg = $data[0]['post_img'];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) return $this->edit($id, $error);

        $result = $this->model->getProduct($id, $postIdCategory);
        $resultId = $this->model->getProductId($id);

        if ($result) {

            $isEmptyImg = $img == "";

            if ($isEmptyImg) $data[0]['img'] = $postImg;

            if (!$isEmptyImg) {

                $fullPath = $this->imgFullPath('products', $id, $img, $postIdCategory);

                $this->moveUpload($fullPath);
                $data['img'] = explode('/', $fullPath);
            }
        }

        if (!$result) {

            // Create a new path
            $fullPath = $this->imgFullPath('products', $id, $img, $postIdCategory);

            $this->moveUpload($fullPath);
            $data['img'] = explode('/', $fullPath);

            // Get img data
            $img = ($img !== '') ? $data['img'][4] : $postImg;

            // Copy from the older to new one
            if (file_exists("../public/resources/img/products/category_{$resultId->id_category}/id_$id/$img")) {

                copy("../public/resources/img/products/category_{$resultId->id_category}/id_$id/$img", "../public/resources/img/products/category_{$postIdCategory}/id_$id/$img");
            }

            // Delete the image in the current folder
            $this->deleteFolder('products', $id, $resultId->id_category);

            $data[0]['img'] = $img;
        }

        $this->model->updateproduct($data[0]);

        $flash = flash('post_message', 'Produto foi atualizado com sucesso!');

        return $this->show($id, $flash);
    }

    public function getPostData()
    {
        // Sanitize data
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$post) return;

        $id = indexParamExistsOrDefault($post, 'id');

        $postIdCategory = indexParamExistsOrDefault($post, 'id_category');

        $productName = indexParamExistsOrDefault($post, 'product_name');

        $productDescription = indexParamExistsOrDefault($post, 'product_description');

        $price = verifyValue($post, 'price');

        if ($price) $price = trim(preg_replace("/[^0-9,.]+/i", "", $price));

        $price = str_replace(",", ".", $price);


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
            'img' => $imgName,
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

            if (empty($data['price'])) {
                $error['price_error'] = "Insira o preço do produto e somente valores monetários.";
                $error['error'] = true;
            }
        }

        return ['data' => $data, 'errorData' => $error];
    }
}
