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
        $results = $this->pagination($table, $id, $limit = 10, '', $orderOption = 'GROUP BY id');

        $activeNumber = $this->model->customQuery("SELECT COUNT(*) as active FROM users WHERE status = 1");

        $inactiveNumber = $this->model->customQuery("SELECT COUNT(*) as inactive FROM users WHERE status = 0");

        View::render('users/index.php', [
            'pageId' => $id,
            'title' => 'Users',
            'activeNumber' => $activeNumber,
            'inactiveNumber' => $inactiveNumber,
            'path' => "users/index",
            'users' => $results[4],
            'flash' => $flash,
            'prev' => $results[0],
            'next' => $results[1],
            'totalResults' => $results[2],
            'totalPages' => $results[3],
        ]);
    }

    public function create($data = false, $error = false)
    {
        $this->isLogin();

        if (isset($_SESSION['submitted'])) {
            unset($_SESSION['submitted']);
        }

        if (!$_SESSION['adm_id'] == 1) {
            return redirect('users');
        }

        View::render('users/create.php', [
            'title' => 'Cadastro de usuários',
            'data' => $data,
            'error' => $error
        ]);
    }

    public function store()
    {
        $this->isLogin();

        $submittedPostData =
            isset($_SESSION['submitted']) &&
            $_SERVER['REQUEST_METHOD'] == 'POST';

        if ($submittedPostData) {
            return redirect('users');
        }

        // Check for post

        // Process Form
        $data = $this->getPostData();
        $error = $data[1];
        $id = $data[0]['id'];

        $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data[0]['email']]);

        if ($this->model->rowCount() > 0) {
            $error['email_error'] = "Já existe um úsuário com esse E-mail";
            $error['error'] = true;
        }


        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) return $this->create($data[0], $error);

        $_SESSION['submitted'] = true;
        // Hash password
        $data[0]['password'] = password_hash($data[0]['password'], PASSWORD_DEFAULT);

        $insertedUser = $this->model->insertUser($data[0]);

        if (!$insertedUser) {
            die('Something went wrong when inserting a user...');
        }

        $flash = flash('register_success', 'Usuário registrado com sucesso!');

        return $this->index(1, $flash);
    }

    public function status($id, $status)
    {
        $isAdminUser = (isset($_SESSION['adm_id']) && $_SESSION['adm_id'] != 1) || !(isset($_SESSION['user_id'])) && $id == 1;

        if (!$isAdminUser) return redirect('home');

        $this->model->updateStatus($id, $status);

        ($status == 1) ? $message = 'Usuário ativado com sucesso' :

            $message = 'Usuário desativado com sucesso!';

        $flash = flash('register_success', $message);
        return $this->index($id = 1, $flash);
    }

    public function show($id, $page = 1, $flash = null)
    {
        $user = $this->model->getAllFrom('users', $id);

        // Pagination for posts with user id
        $table = 'posts';
        $results = $this->pagination($table, $page, $limit = 4, ['user_id', $user->id], $orderOption = 'ORDER BY id DESC');

        // Display results
        $pageInfo = ($page > 1) ? " | Página $page" : '';
        return View::render('users/show.php', [
            'title' => 'Funcionário ' . $user->name . $pageInfo,
            'pageId' => $id,
            'user' => $user,
            'flash' => $flash,
            'page' => $page,
            'path' => "users/show/$id",
            'posts' => $results[4],
            'prev' => $results[0],
            'next' => $results[1],
            'totalResults' => $results[2],
            'totalPages' => $results[3],
        ]);
    }

    public function edit($id, $error = null, $flash = null)
    {
        $this->isLogin();

        $data = $this->model->getAllFrom('users', $id);

        $userAdminOne = $id == 1 && $_SESSION['user_id'] == 1;

        $isSameLoggedUser = $data->id != 1 && $_SESSION['user_id'] == $id || $_SESSION['adm_id'] == 1 && $id != 1;


        if ($userAdminOne) {
            View::render('users/edit.php', [
                'title' => 'Editar perfil de ' . $data->name,
                'data' => $data,
                'flash' => $flash,
                'error' => $error
            ]);
        }

        if (!$userAdminOne) {

            if (!$isSameLoggedUser) return redirect('users');

            View::render('users/edit.php', [
                'title' => 'Editar perfil de ' . $data->name,
                'data' => $data,
                'flash' => $flash,
                'error' => $error
            ]);
        }
    }

    public function update()
    {
        $this->isLogin();

        $submittedPostData = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$submittedPostData) return;

        // Process Form
        $data = $this->getPostData();
        $error = $data[1];
        $id = $data[0]['id'];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) return $this->edit($id, $error);


        $img = $data[0]['img'];
        $postImg = $data[0]['post_img'];

        $isEmptyImg = $img == "";

        if ($isEmptyImg) $data[0]['img'] = $postImg;

        if (!$isEmptyImg) {

            $fullPath = $this->imgFullPath('users', $id, $img);
            $this->moveUpload($fullPath);

            $data['img'] = explode('/', $fullPath);
        }

        $this->model->updateUser($data[0]);

        $updatedUser = $this->model->rowCount();

        if (!$updatedUser) {
            die('Something went wrong when updating the user...');
        }

        $flash = flash('register_success', 'Atualizado com sucesso!');

        return $this->edit($id, $error = null, $flash);
    }

    public function login($flash = null)
    {
        // if user is already logged redirect to profile
        if ($_SESSION['user_id']) {
            $userId = $_SESSION['user_id'];

            redirect("users/show/$userId");
        }

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest) return View::render('users/login.php', ['flash' => $flash]);

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

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) {
            return View::render('users/login.php', [
                'data' => $data[0],
                'error' => $error
            ]);
        }

        // Check an set logged in user
        $loggedInUser = $this->model->login($data[0]['email'], $data[0]['password']);

        if (!$loggedInUser) {
            $error['password_error'] = "Email ou senha incorretos";

            return View::render('users/login.php', [
                'data' => $data[0],
                'error' => $error
            ]);
        }

        // Create session
        $this->model->createUserSession($loggedInUser);

        $flash = flash('register_success', 'Logado com sucesso!');
        return $this->show($_SESSION['user_id'], 1, $flash);
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $id = isset($_POST['id']) ? trim($_POST['id']) : '';

        $adm = isset($_POST['adm']) ? intval(trim($_POST['adm'])) : 0;

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';

        $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';

        $email = isset($_POST['email']) ? trim($_POST['email']) : '';

        $password = isset($_POST['password']) ? trim($_POST['password']) : '';

        $img = isset($_FILES['img']) ? $_FILES['img']['name'] : null;

        $postImg = isset($_POST['img']) ? $_POST['img'] : '';

        $bio = isset($_POST['bio']) ? trim($_POST['bio']) : null;

        $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

        $nameError = isset($_POST['name_error']) ? trim($_POST['name_error']) : '';

        $lastNameError = isset($_POST['last_name_error']) ? trim($_POST['last_name_error']) : '';

        $emailError = isset($_POST['email_error']) ? trim($_POST['email_error']) : '';

        $passwordError = isset($_POST['password_error']) ? trim($_POST['password_error']) : '';

        $confirmPasswordError =
            isset($_POST['confirm_password_error']) ? trim($_POST['confirm_password_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'adm' => $adm,
            'name' => $name,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $confirmPassword,
            'bio' => $bio,
            'img' => $img,
            'post_img' => $postImg,
        ];

        $error = [
            'name_error' => $nameError,
            'last_name_error' => $lastNameError,
            'email_error' => $emailError,
            'password_error' => $passwordError,
            'confirm_password_error' => $confirmPasswordError,
            'error' => false
        ];

        if (isset($_FILES['img']) || $postImg) {
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
