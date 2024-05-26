<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Classes\Pagination;
use Core\Controller;
use Core\View;

use App\Config\Config;

class Categories extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Category');
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

        if (isset($_SESSION['submitted'])) unset($_SESSION['submitted']);

        View::render('categories/create.php', [
            'title' => 'Adicione mais uma categoria',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->isLogin();

        $submittedPostData =
            isset($_SESSION['submitted']) &&
            $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$submittedPostData) {
            return redirect('categories');
        }

        $result = $this->getPostData();
        $data = $result[0];
        $error = $result[1];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) return $this->create($data, $error);

        $fullPath = $this->imgCreateHandler('categories');

        $this->moveUpload($fullPath);

        $addedCategory = $this->model->addCategory($data);
        if (!$addedCategory) {
            die('Algo deu errado..');
            return;
        }

        $_SESSION['submitted'] = true;
        $flash = flash('post_message', 'Imagem adicionada com sucesso');

        $id = $this->model->lastId();

        return $this->show($id, 1, $flash);
    }

    public function show($requestData)
    {
        $categoryId = isset($requestData['show']) && !empty($requestData['show']) ? $requestData['show'] : 1;

        $lastKey = array_key_last($requestData);

        $pageId = !($lastKey == 'show') ? end($requestData) : 1;

        $urlPath = "categories/show/$categoryId";

        // get category fata
        $data = $this->model->getAllFrom('categories', $categoryId);
        // get user data
        $user = $this->model->getAllFrom('users', $data->user_id);

        // Pagination for products with id category
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

    public function edit($id, $error = false)
    {
        $this->isLogin();
        $data = $this->model->getAllFrom('categories', $id);

        View::render('categories/edit.php', [
            'title' => "Editar - $data->category_name",
            'data' => $data,
            'error' => $error
        ]);
    }

    public function update()
    {
        $this->isLogin();

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest) {
            redirect('categories');
            return;
        }

        $data = $this->getPostData();
        $error = $data[1];
        $id = $data[0]['id'];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) return $this->edit($id, $error);

        $img = $data[0]['img'];
        $postImg = $data[0]['post_img'];

        $isEmptyImg = $img == "";

        if (!$isEmptyImg) {

            $fullPath = $this->imgFullPath('categories', $id, $img);
            $this->moveUpload($fullPath);

            $data['img'] = explode('/', $fullPath);
        }

        if ($isEmptyImg) $data[0]['img'] = $postImg;

        $this->model->updateCategory($data[0]);

        $flash = flash('post_message', 'Categoria foi atualizada com sucesso!');

        // return $this->show($id, 1, $flash);
    }

    // Delete function for controllers
    public function destroy($id)
    {
        $url = explode('/', $_SERVER['QUERY_STRING']);

        // Get table with url
        $table = $url[0];
        $idCategory = $url[3] ?? null;

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest) {
            redirect($table);
            return;
        }

        $this->model->deleteQuery('products', ['id_category' => $id]);
        $this->model->deleteQuery($table, ['id' => $id]);

        $itemWasDeleted = $this->model->rowCount() > 0;

        if (!$itemWasDeleted) {
            $flash = flash('register_seccess', 'Ocorreu um erro');
            redirect($table);

            return;
        }

        $this->deleteFolder('products', $id, $idCategory, true);
        $this->deleteFolder($table, $id);

        // Delete everything img with this category
        $flash = flash('register_seccess', 'Deletado com sucesso');

        return $this->index(1, $flash);
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $id = isset($_POST['id']) ? trim($_POST['id']) : '';

        $categoryName = isset($_POST['category_name']) ? (trim($_POST['category_name'])) : '';

        $categoryDescription = isset($_POST['category_description']) ? trim($_POST['category_description']) : '';

        $img = isset($_FILES['img']) ? $_FILES['img'] : null;

        $postImg = isset($_POST['img']) ? $_POST['img'] : '';

        $userId =
            isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

        $categoryNameError = isset($_POST['category_name_error']) ? trim($_POST['category_name_error']) : '';

        $categoryDescriptionError =
            isset($_POST['category_description_error'])
            ? trim($_POST['category_description_error']) : '';

        $imgPathError = isset($_POST['img_error']) ? trim($_POST['img_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'category_name' => $categoryName,
            'category_description' => $categoryDescription,
            'img' => $img['name'],
            'post_img' => $postImg,
            'user_id' => $userId,
        ];

        $error = [
            'category_name_error' => $categoryNameError,
            'category_description_error' => $categoryDescriptionError,
            'img_error' => $imgPathError,
            'error' => false
        ];

        $validate = $this->imgValidate();

        $isFilesAndEmptyPostImg =
            isset($_FILES['img']) && $postImg == '';

        if ($isFilesAndEmptyPostImg) {

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

        if (empty($data['category_name'])) {
            $error['category_name_error'] = "Coloque o nome da categoria";
            $error['error'] = true;
        }

        if (empty($data['category_description'])) {
            $error['category_description_error'] = "Coloque uma descrição para imagem";
            $error['error'] = true;
        }

        return [$data, $error];
    }
}
