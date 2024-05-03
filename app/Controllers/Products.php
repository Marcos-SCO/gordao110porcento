<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Config\Config;

use function PHPSTORM_META\type;

class Products extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Product');
    }

    public function index($id = 1, $flash = false)
    {
        $table = 'products';
        $results = $this->pagination($table, $id, $limit = 12, '', $orderOption = 'ORDER BY id DESC');

        // Category elements from table categories
        $categoryElements = $this->model->customQuery('SELECT id, category_name FROM categories', null, 1);
        View::render('products/index.php', [
            'title' => "Ofertas | Página $id",
            'categoryElements' => $categoryElements,
            'products' => $results[4],
            'flash' => $flash,
            'path' => "products/index",
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['submitted'])) {
            $result = $this->getPostData();
            $data = $result[0];
            $error = $result[1];

            // Validate data
            if ($error['error'] != true) {
                // Create a folder in products
                $fullPath = $this->imgCreateHandler('products', $data['id_category']);

                $this->moveUpload($fullPath);

                if ($this->model->addproduct($data)) {
                    $_SESSION['submitted'] = true;
                    $flash = flash('post_message', 'Produto adicionado com successo');
                    $id = $this->model->lastId();
                    return $this->show($id, $flash);
                } else {
                    die('Algo deu errado..');
                }
            } else {
                return $this->create($data, $error);
            }
        } else {
            redirect('products');
        }
    }

    public function show($id, array $flash = null)
    {
        $data = $this->model->getAllFrom('products', $id);
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];
            $postIdCategory = $data[0]['id_category'];
            $img = $data[0]['img'];
            $postImg = $data[0]['post_img'];

            if ($error['error'] != true) {
                $result = $this->model->getProduct($id, $postIdCategory);
                $resultId = $this->model->getProductId($id);

                if ($result) {
                    if ($img !== "") {
                        $fullPath = $this->imgFullPath('products', $id, $img, $postIdCategory);
                        $this->moveUpload($fullPath);
                        $data['img'] = explode('/', $fullPath);
                    } else {
                        $data[0]['img'] = $postImg;
                    }
                } else {
                    // Create a new path
                    $fullPath = $this->imgFullPath('products', $id, $img, $postIdCategory);
                    $this->moveUpload($fullPath);
                    $data['img'] = explode('/', $fullPath);

                    // Get img data
                    $img = ($img !== '') ? $data['img'][4] : $postImg;

                    // Copy from the older to new one
                    if (file_exists("../public/img/products/category_{$resultId->id_category}/id_$id/$img")) {
                        copy("../public/img/products/category_{$resultId->id_category}/id_$id/$img", "../public/img/products/category_{$postIdCategory}/id_$id/$img");
                    }

                    // Delete the image in the current folder
                    $this->deleteFolder('products', $id, $resultId->id_category);

                    $data[0]['img'] = $img;
                }
                
                $this->model->updateproduct($data[0]);
                $flash = flash('post_message', 'Produto foi atualizado com sucesso!');

                return $this->show($id, $flash);
            } else {
                return $this->edit($id, $error);
            }
        }
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $postIdCategory = isset($_POST['id_category']) ? trim($_POST['id_category']) : 1;
        $productName = isset($_POST['product_name']) ? (trim($_POST['product_name'])) : '';
        $productDescription = isset($_POST['product_description']) ? trim($_POST['product_description']) : '';
        $price = isset($_POST['price']) ? trim(preg_replace("/[^0-9,.]+/i", "", $_POST["price"])) : '';
        $price = str_replace(",", ".", $price);
        $img = isset($_FILES['img']) ? $_FILES['img'] : null;
        $postImg = isset($_POST['img']) ? $_POST['img'] : '';
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $postIdCategoryError = isset($_POST['id_category_error']) ? trim($_POST['id_category_error']) : '';
        $productNameError = isset($_POST['product_name_error']) ? trim($_POST['product_name_error']) : '';
        $productDescriptionError = isset($_POST['product_description_error']) ? trim($_POST['product_description_error']) : '';
        $priceError = isset($_POST['price_error']) ? trim($_POST['price_error']) : '';
        $imgPathError = isset($_POST['img_error']) ? trim($_POST['img_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'id_category' => $postIdCategory,
            'product_name' => $productName,
            'product_description' => $productDescription,
            'price' => $price,
            'img' => $img['name'],
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

        return [$data, $error];
    }
}
