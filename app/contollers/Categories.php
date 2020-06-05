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
        $results = $this->pagination($table, $id, $limit = 3, '', $orderOption = 'DESC');
        // Category elements from table categories
        $categoryElements = $this->model->customQuery('SELECT id, category_name FROM categories', null, 1);
        View::render('categories/index.php', [
            'title' => 'Todas Categorias',
            'categoryElements' => $categoryElements,
            'categories' => $results[4],
            'flash' => $flash,
            'path' => 'categories/index',
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

        View::render('categories/create.php', [
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
                    return $this->show($id, 1, $flash);
                } else {
                    die('Algo deu errado..');
                }
            } else {
                return $this->create($data, $error);
            }
        } else {
            redirect('categories');
        }
    }

    public function show($id, $page = 1, array $flash = null)
    {
        // get category fata
        $data = $this->model->getAllFrom('categories', $id);
        // get user data
        $user = $this->model->getAllFrom('users', $data->user_id);

        // Pagination for products with id category
        $table = 'products';
        $results = $this->pagination($table, $page, $limit = 4, ['id_category', $id], $orderOption = 'DESC');
        
        $categoryElements = $this->model->customQuery('SELECT id, category_name FROM categories', null, 1);
        // Display results
        return View::render('categories/show.php', [
            'title' => $data->category_name.' | Página '. $page,
            'category_description' => $data->category_description,
            'categoryElements' => $categoryElements,
            'pageId' => $id,
            'data' => $data,
            'user' => $user,
            'flash' => $flash,
            'page' => $page,
            'path' => "categories/show/$id",
            'products' => $results[4],
            'prev' => $results[0],
            'next' => $results[1],
            'totalResults' => $results[2],
            'totalPages' => $results[3],
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

                return $this->show($id, 1, $flash);
            } else {
                return $this->edit($id, $error);
            }
        } else {
            redirect('categories');
        }
    }

    // Delete functoin for controllers
    public function destroy($id)
    {
        $url = explode('/', $_SERVER['QUERY_STRING']);
        // Get table with url
        $table = $url[0];
        $idCategory = $url[3] ?? null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->deleteQuery('products', ['id_category' => $id]);
            $this->model->deleteQuery($table, ['id' => $id]);
            if ($this->model->rowCount() > 0) {
                $this->deleteFolder('products', $id, $idCategory, true);
                $this->deleteFolder($table, $id);
                // Delete everything img with this category
                $flash = flash('register_seccess', 'Deletado com sucesso');
                return $this->index(1, $flash);
            } else {
                $flash = flash('register_seccess', 'Ocorreu um erro');
                redirect($table);
            }
        } else {
            redirect($table);
        }
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
