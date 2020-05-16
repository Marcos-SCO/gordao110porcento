<?php

declare(strict_types=1);

namespace App\Controllers;

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

    public function index($id = 1, $flash = false)
    {
        $table = 'categories';
        $results = $this->pagination($table, $id, $limit = 2, $option = 'DESC');
        View::renderTemplate('categories/index.html', [
            'title' => 'Galeria de imagens',
            'categories' => $results[4],
            'flash' => $flash,
            'table' => $table,
            'pageId' => $id,
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

        View::renderTemplate('categories/create.html', [
            'title' => 'Adicione mais uma categoria',
            'data' => $data,
            'error' => $error,
        ]);
    }

    public function store()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['submitted'])) {
            $result = $this->getPostData();
            $data = $result[0];
            $error = $result[1];

            // Validate data
            if ($error['error'] != true) {
                $fullPath = $this->imgCreateHandler('categories');
                $this->moveUpload($fullPath);

                if ($this->model->addCategory($data)) {
                    $_SESSION['submitted'] = true;
                    $flash = flash('post_message', 'Imagem adicionada com successo');
                    $id = $this->model->lastId();
                    return $this->show($id, $flash);
                } else {
                    die('Algo deu errado..');
                }
            } else {
                return $this->create($data, $error);
            }
        }
    }

    public function show($id, array $flash = null)
    {
        $data = $this->model->getAllFrom('categories', $id);
        $user = $this->model->getAllFrom('users', $data->user_id);
        $products = $this->model->getProducts($data->id);
        return View::renderTemplate('categories/show.html', [
            'category_description' => $data->category_description,
            'data' => $data,
            'user' => $user,
            'products' => $products,
            'flash' => $flash
        ]);
    }

    public function edit($id, $error = false)
    {
        $this->isLogin();
        $data = $this->model->getAllFrom('categories', $id);

        View::renderTemplate('categories/edit.html', [
            'title' => "Editar - $data->category_name",
            'data' => $data,
            'error' => $error
        ]);
    }

    public function update()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];

            if ($error['error'] != true) {
                $img = $data[0]['img'];
                $postImg = $data[0]['post_img'];
                if ($img !== "") {
                    $fullPath = $this->imgFullPath('categories', $id, $img);
                    $this->moveUpload($fullPath);
                    $data['img'] = explode('/', $fullPath);
                } else {
                    $data[0]['img'] = $postImg;
                }

                $this->model->updateCategory($data[0]);
                $flash = flash('post_message', 'Gategoria foi atualizada com sucesso!');

                return $this->show($id, $flash);
            } else {
                return $this->edit($id, $error);
            }
        }
    }

    public function delete($id)
    {
        $this->model->deletePost('categories', ['id' => $id]);
        if ($this->model->rowCount() > 0) {
            $this->deleteFolder('categories', $id);
            $flash = flash('register_seccess', 'Categoria foi deletada com sucesso');
            return $this->index(1, $flash);
        }
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $categoryName = isset($_POST['category_name']) ?(trim($_POST['category_name'])) : '';
        $categoryDescription = isset($_POST['category_description']) ? trim($_POST['category_description']) : '';
        $img = isset($_FILES['img']) ? $_FILES['img'] : null;
        $postImg = isset($_POST['img']) ? $_POST['img'] : '';
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $categoryNameError = isset($_POST['category_name_error']) ? trim($_POST['category_name_error']) : '';
        $categoryDescriptionError = isset($_POST['category_description_error']) ? trim($_POST['category_description_error']) : '';
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

        if (empty($data['category_name'])) {
            $error['category_name_error'] = "Coloque o nome da categoria";
            $error['error'] = true;
        }
        if (empty($data['category_description'])) {
            $error['category_description_error'] = "Coloque uma descrição para imagem";
            $error['error'] = true;
        }
        if (isset($_FILES) && $postImg == '') {
            if (empty($data['img'])) {
                $error['img_error'] = "Insira uma imagem";
                $error['error'] = true;
            }
        }

        return [$data, $error];
    }
}
