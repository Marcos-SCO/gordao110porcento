<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

class Users extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('User');
    }

    public function index($id = 1, $flash = null)
    {
        $this->isLogin();
        $table = 'users';
        $results = $this->pagination($table, $id, $limit = 10, '', $orderOption = 'AND `status` DESC');

        View::render('users/index.php', [
            'title' => 'Users',
            'users' => $results[4],
            'flash' => $flash,
            'table' => $table,
            'pageId' => $id,
            'prev' => $results[0],
            'next' => $results[1],
            'totalResults' => $results[2],
            'totalPages' => $results[3],
        ]);
    }

    public function create($data = false, $error = false)
    {
        $this->isLogin();

        View::render('users/create.php', [
            'title' => 'Cadastro',
            'data' => $data,
            'error' => $error
        ]);
    }

    public function store()
    {
        $this->isLogin();

        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process Form
            $data = $this->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];

            $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data[0]['email']]);

            if ($this->model->rowCount() > 0) {
                $error['email_error'] = "Já existe um úsuário com esse E-mail";
                $error['error'] = true;
            }

            // Make sure error are empty
            if ($error['error'] != true) {
                // Hash password
                $data[0]['password'] = password_hash($data[0]['password'], PASSWORD_DEFAULT);
                // Register user
                if ($this->model->insertUser($data[0])) {
                    $flash = flash('register_success', 'Usuário registrado com sucesso!');
                    return $this->index(1,$flash);
                } else {
                    die('Algo deu errado...');
                }
            } else {
                return $this->create($data[0], $error);
            }
        }
    }

    public function status($id, $status)
    {
        if ((isset($_SESSION['adm_id']) && $_SESSION['adm_id'] != 1) || !(isset($_SESSION['user_id'])) && $id == 1) {
            return redirect('home');
        } else {
            $this->model->updateStatus($id, $status);
            ($status == 1) ? $message = 'Usuário ativado com sucesso' : $message = 'Usuário desativado com sucesso!';
            $flash = flash('register_success', $message);
            return $this->index($id = 1, $flash);
        }
    }

    public function show($id)
    {
        $user = $this->model->getAllFrom('users', $id);
        // $posts = $this->model->getAllFrom('posts', $data->id, 'user_id');
        $posts = $this->model->selectQuery('posts', "WHERE user_id = $user->id ORDER BY created_at DESC");

        View::render('users/show.php', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function edit($id, $error = null, $flash = null)
    {
        $this->isLogin();

        $data = $this->model->getAllFrom('users', $id);
        if ($id == 1 && $_SESSION['user_id'] == 1) {
            View::render('users/edit.php', [
                'data' => $data,
                'flash' => $flash,
                'error' => $error
            ]);
        } else {
            if ($data->id != 1) {
                View::render('users/edit.php', [
                    'data' => $data,
                    'flash' => $flash,
                    'error' => $error
                ]);
            } else {
                return $this->index(1, null);
            }
        }
    }

    public function update()
    {
        $this->isLogin();

        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process Form
            $data = $this->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];
            // Make sure error are empty
            if ($error['error'] != true) {
                $img = $data[0]['img'];
                $postImg = $data[0]['post_img'];
                if ($img !== "") {
                    $fullPath = $this->imgFullPath('users', $id, $img);
                    $this->moveUpload($fullPath);
                    $data['img'] = explode('/', $fullPath);
                } else {
                    $data[0]['img'] = $postImg;
                }

                $this->model->updateUser($data[0]);
                // Update user
                if ($this->model->rowCount()) {
                    $flash = flash('register_success', 'Atualizado com sucesso!');
                    return $this->edit($id, $error = null, $flash);
                } else {
                    die('Algo deu errado...');
                }
            } else {
                return $this->edit($id, $error);
            }
        }
    }

    public function login($flash = null)
    {
        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process
            $data = $this->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];

            // Dont let users with status 0 login
            if ($data[0]['email'] != '') {
                $this->model->blockLogin($data[0]['email']);
            }

            $this->model->customQuery("SELECT `email` FROM users WHERE `email` = :email", ['email' => $data[0]['email']]);

            // Check for users/email
            if ($_POST['email'] != '' && $this->model->rowCount() <= 0) {
                // User not Found
                $error['email_error'] = "Nenhum usuário encontrado";
                $error['error'] = true;
            }

            // Make sure error are empty
            if ($error['error'] != true) {
                // Validate
                // Check an set logged in user
                $loggedInUser = $this->model->login($data[0]['email'], $data[0]['password']);
                if ($loggedInUser) {
                    // Create session
                    $this->model->createUserSession($loggedInUser);
                    $flash = flash('register_success', 'Logado com sucesso!');
                    return $this->index(1, $flash);
                } else {
                    $error['password_error'] = "Email ou senha incorretos";
                    return View::render('users/login.php', [
                        'data' => $data[0],
                        'error' => $error
                    ]);
                }
            } else {
                // Load view with errors
                return View::render('users/login.php', [
                    'data' => $data[0],
                    'error' => $error
                ]);
            }
        } else {
            return View::render('users/login.php', ['flash' => $flash]);
        }
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $adm = isset($_POST['adm']) ? intval(trim($_POST['adm'])) : 0;
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $lastname = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $img = isset($_FILES['img']) ? $_FILES['img']['name'] : null;
        $postImg = isset($_POST['img']) ? $_POST['img'] : '';
        $bio = isset($_POST['bio']) ? trim($_POST['bio']) : null;
        $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
        $nameError = isset($_POST['name_error']) ? trim($_POST['name_error']) : '';
        $lastnameError = isset($_POST['last_name_error']) ? trim($_POST['last_name_error']) : '';
        $emailError = isset($_POST['email_error']) ? trim($_POST['email_error']) : '';
        $passwordError = isset($_POST['password_error']) ? trim($_POST['password_error']) : '';
        $confirmPasswordError = isset($_POST['confirm_password_error']) ? trim($_POST['confirm_password_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'adm' => $adm,
            'name' => $name,
            'last_name' => $lastname,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $confirmPassword,
            'bio' => $bio,
            'img' => $img,
            'post_img' => $postImg,
        ];

        $error = [
            'name_error' => $nameError,
            'last_name_error' => $lastnameError,
            'email_error' => $emailError,
            'password_error' => $passwordError,
            'confirm_password_error' => $confirmPasswordError,
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

        if (isset($_POST['name']) || isset($_POST['last_name'])) {
            // Name
            if (empty($data['name'])) {
                $error['name_error'] = "Digite o nome";
                $error['error'] = true;
            }
            if (empty($data['last_name'])) {
                $error['last_name_error'] = "Digite o sobrenome";
                $error['error'] = true;
            }
        }

        if (isset($_POST['email']) != '') {
            // Validate Email
            if (empty($data['email'])) {
                $error['email_error'] = "Digite o E-mail";
                $error['error'] = true;
            }
            if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                $error['email_error'] = "E-mail inválido";
                $error['error'] = true;
            }
        }

        if (isset($_POST['password'])) {
            if (empty($data['password'])) {
                $error['password_error'] = "Digite a senha";
                $error['error'] = true;
            } elseif (strlen($data['password']) < 6) {
                $error['password_error'] = "Senha precisa no minimo de ser maior que 6 caracteres";
                $error['error'] = true;
            }
        }
        // Password validate
        if (isset($_POST['confirm_password'])) {
            // Password
            if (empty($data['confirm_password'])) {
                $error['confirm_password_error'] = "Confirme a senha";
                $error['error'] = true;
            } elseif ($data['password'] != $data['confirm_password']) {
                $error['confirm_password_error'] = "Senhas estão diferentes";
                $error['error'] = true;
            }
        }
        return [$data, $error];
    }

    public function logout()
    {
        return $this->model->destroy();
    }
}
