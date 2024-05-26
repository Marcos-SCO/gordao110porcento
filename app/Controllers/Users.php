<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Classes\Pagination;
use Core\Controller;
use Core\Error as CoreError;
use Core\View;
use Error;

class Users extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('User');
    }

    public function getPostData()
    {
        // Sanitize data
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$post) return;

        $id = indexParamExistsOrDefault($post, 'id');

        $adm = indexParamExistsOrDefault($post, 'adm', 0);

        $name = indexParamExistsOrDefault($post, 'name');

        $lastName = indexParamExistsOrDefault($post, 'last_name');

        $email = indexParamExistsOrDefault($post, 'email');

        $password = verifyValue($post, 'password');

        $imgFiles = indexParamExistsOrDefault($_FILES, 'img');

        $imgName = indexParamExistsOrDefault($_FILES, 'name');

        $postImg = indexParamExistsOrDefault($post, 'img');

        $bio = indexParamExistsOrDefault($post, 'bio');

        $confirmPassword =
            indexParamExistsOrDefault($post, 'confirm_password', '');

        $nameError = indexParamExistsOrDefault($post, 'name_error');

        $lastNameError = indexParamExistsOrDefault($post, 'last_name_error');

        $emailError = indexParamExistsOrDefault($post, 'email_error');

        $passwordError = indexParamExistsOrDefault($post, 'password_error');

        $confirmPasswordError = indexParamExistsOrDefault($post, 'confirm_password_error');

        // Add data to array
        $data = [
            'id' => $id,
            'adm' => $adm,
            'name' => $name,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $password ? trim($password) : false,
            'confirm_password' => $confirmPassword,
            'bio' => $bio,
            'img' => $imgFiles,
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

        if ($imgFiles || $postImg) {
            $validate = $this->imgValidate();

            if (isset($_FILES['img']) && $postImg == '') {

                if (empty($data['img'])) {
                    $errorData['img_error'] = "Insira uma imagem";
                    $errorData['error'] = true;
                }

                if (!empty($data['img'])) {
                    $errorData['img_error'] = $validate[1];
                    $errorData['error'] = $validate[0];
                }
            } else if ($postImg && !empty($data['img'])) {
                $errorData['img_error'] = $validate[1];
                $errorData['error'] = $validate[0];
            }
        }

        if (isset($_POST['name']) || isset($_POST['last_name'])) {
            // Name
            if (empty($data['name'])) {
                $errorData['name_error'] = "Digite o nome";
                $errorData['error'] = true;
            }

            if (empty($data['last_name'])) {
                $errorData['last_name_error'] = "Digite o sobrenome";
                $errorData['error'] = true;
            }
        }

        if (isset($_POST['email']) != '') {

            // Validate Email
            if (empty($data['email'])) {
                $errorData['email_error'] = "Digite o E-mail";
                $errorData['error'] = true;
            }

            if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                $errorData['email_error'] = "E-mail inválido";
                $errorData['error'] = true;
            }
        }

        if (isset($_POST['password'])) {

            if (empty($data['password'])) {

                $errorData['password_error'] = "Digite a senha";
                $errorData['error'] = true;
            }

            if ($data['password'] && strlen($data['password']) < 6) {

                $errorData['password_error'] = "Senha precisa no minimo de ser maior que 6 caracteres";
                $errorData['error'] = true;
            }
        }

        // Password validate
        if (isset($_POST['confirm_password'])) {

            // Password
            if (empty($data['confirm_password'])) {
                $errorData['confirm_password_error'] = "Confirme a senha";
                $errorData['error'] = true;
            } elseif ($data['password'] != $data['confirm_password']) {
                $errorData['confirm_password_error'] = "Senhas estão diferentes";
                $errorData['error'] = true;
            }
        }

        return ['data' => $data, 'errorData' => $error];
    }

    public function index($requestData)
    {
        $this->isLogin();

        $table = 'users';

        $pageId = isset($requestData['users']) && !empty($requestData['users']) ? $requestData['users'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 10, '', $orderOption = 'GROUP BY id');

        $activeNumber = $this->model->customQuery("SELECT COUNT(*) as active FROM users WHERE status = 1");

        $inactiveNumber = $this->model->customQuery("SELECT COUNT(*) as inactive FROM users WHERE status = 0");

        View::render('users/index.php', [
            'pageId' => $pageId,
            'title' => 'Users',
            'activeNumber' => $activeNumber,
            'inactiveNumber' => $inactiveNumber,
            'path' => "users",
            'users' => $results['tableResults'],
            'prev' => $results['prev'],
            'next' => $results['next'],
            'totalResults' => $results['totalResults'],
            'totalPages' => $results['totalPages'],
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
        $id = $data['id'];

        $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data['email']]);

        if ($this->model->rowCount() > 0) {
            $errorData['email_error'] = "Já existe um úsuário com esse E-mail";
            $errorData['error'] = true;
        }


        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->create($data, $error);

        $_SESSION['submitted'] = true;
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $insertedUser = $this->model->insertUser($data);

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

    public function show($requestData)
    {
        if (!is_array($requestData)) $requestData = [];

        $userPageId = isset($requestData['show']) && !empty($requestData['show']) ? $requestData['show'] : 1;

        $lastKey = array_key_last($requestData);

        $pageId = !($lastKey == 'show') ? end($requestData) : 1;

        if ($userPageId && !($lastKey == 'show')) $pageId = $userPageId;

        $user = $this->model->getAllFrom('users', $userPageId);

        // Pagination for posts with user id
        $table = 'posts';

        $results = Pagination::handler($table, $pageId, $limit = 4, ['user_id', $user->id], $orderOption = 'ORDER BY id DESC');

        // Display results
        $pageInfo = ($userPageId > 1) ? " | Página $userPageId" : '';

        return View::render('users/show.php', [
            'title' => 'Funcionário ' . $user->name . $pageInfo,
            'pageId' => $pageId,
            'user' => $user,
            'page' => $pageId,
            'path' => "users/show/$userPageId",
            'posts' => $results['tableResults'],
            'prev' => $results['prev'],
            'next' => $results['next'],
            'totalResults' => $results['totalResults'],
            'totalPages' => $results['totalPages'],
        ]);
    }

    public function edit($requestData)
    {
        $this->isLogin();

        $userId = indexParamExistsOrDefault($requestData, 'edit');

        if (!$userId) throw new \Exception('User id is missing...');

        $flashData = indexParamExistsOrDefault($requestData, 'flash');

        $data = $this->model->getAllFrom('users', $userId);

        $isUserAdminOne = $userId == 1 && $_SESSION['user_id'] == 1;

        $isSameLoggedUser = $data->id != 1 && $_SESSION['user_id'] == $userId || $_SESSION['adm_id'] == 1 && $userId != 1;

        if ($isUserAdminOne) {
            View::render('users/edit.php', [
                'title' => 'Editar perfil de ' . $data->name,
                'data' => $data,
                'flash' => $flashData,
                // 'error' => $error
            ]);
        }

        if (!$isUserAdminOne) {

            if (!$isSameLoggedUser) return redirect('users');

            View::render('users/edit.php', [
                'title' => 'Editar perfil de ' . $data->name,
                'data' => $data,
                'flash' => $flashData,
                // 'error' => $error
            ]);
        }
    }

    public function update()
    {
        $this->isLogin();

        $submittedPostData = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$submittedPostData) return;

        // Process Form
        $postResultData = $this->getPostData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $id = $data['id'];

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) {

            $errorArrayData = [
                'edit' => $id,
                'data' => $data,
                'error' => $errorData
            ];

            return $this->edit($errorArrayData);
        }


        $img = $data['img'];
        $imgName = indexParamExistsOrDefault($img, 'name');

        $postImg = $data['post_img'];

        $isEmptyImg = $imgName == "";

        if ($isEmptyImg) $data['img'] = $postImg;

        if (!$isEmptyImg) {

            $fullPath = $this->imgFullPath('users', $id, $imgName);
            $this->moveUpload($fullPath);

            $explodedPath = explode('/', $fullPath);

            $data['img'] = end($explodedPath);
        }

        $this->model->updateUser($data);

        $updatedUser = $this->model->rowCount();

        if (!$updatedUser) {
            die('Something went wrong when updating the user...');
        }

        $flash = flash('register_success', 'Atualizado com sucesso!');

        $requestData = [
            'edit' => $id,
            'data' => $data,
            'flash' => $flash,
        ];

        // return $this->edit($requestData);

        return redirect("users/edit/$id/");
    }

    public function login($flash = null)
    {
        // if user is already logged redirect to profile
        $sessionUserId = indexParamExistsOrDefault($_SESSION, 'user_id');

        if ($sessionUserId) redirect("users/show/$sessionUserId");

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest) {

            return View::render(
                'users/login.php',
                [
                    'flash' => $flash,
                    'title' => 'Users login',
                ]
            );
        }

        // Process
        $postResultData = $this->getPostData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $id = $data['id'];

        // Don't let users with status 0 login
        if ($data['email'] != '') {

            $this->model->blockLogin($data['email']);
        }

        $this->model->customQuery("SELECT `email` FROM users WHERE `email` = :email", ['email' => $data['email']]);

        // Check for users/email
        if ($_POST['email'] != '' && $this->model->rowCount() <= 0) {
            // User not Found
            $errorData['email_error'] = "Nenhum usuário encontrado";
            $errorData['error'] = true;
        }

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) {

            return View::render('users/login.php', [
                'data' => $data,
                'error' => $errorData
            ]);
        }

        // Check an set logged in user
        $loggedInUser = $this->model->login($data['email'], $data['password']);

        $userId = objParamExistsOrDefault($loggedInUser, 'id');

        if (!$loggedInUser) {
            $errorData['password_error'] = "Email ou senha incorretos";

            return View::render('users/login.php', [
                'title' => 'Users Login',
                'data' => $data,
                'error' => $errorData
            ]);
        }

        // Create session
        $this->model->createUserSession($loggedInUser);

        $flash = flash('register_success', 'Logado com sucesso!');

        $requestData = [
            'show' => $userId,
            'data' => $data,
            'flash' => $flash,
        ];

        return $this->show($requestData);
    }

    public function logout()
    {
        return $this->model->destroy();
    }
}
