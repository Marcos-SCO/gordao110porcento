<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;
use App\Classes\RequestData;
use Core\Controller;
use Core\View;

class Users extends Controller
{
    public $model;
    public $imagesHandler;

    public function __construct()
    {
        $this->model = $this->model('User');
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

        if (empty($data['name'])) {
            $errors['name_error'] = "Digite o nome";
            $errors['error'] = true;
        }

        if (empty($data['last_name'])) {
            $errors['last_name_error'] = "Digite o sobrenome";
            $errors['error'] = true;
        }

        return ['data' => $data, 'errorData' => $errors];
    }

    public function validateInputsLogin()
    {
        $requestParams = RequestData::getRequestParams();

        $data = indexParamExistsOrDefault($requestParams, 'data', []);
        $errors =
            indexParamExistsOrDefault($requestParams, 'errors', []);

        // Validate Email
        if (empty($data['email'])) {
            $errors['email_error'] = "Digite o E-mail";
            $errors['error'] = true;
        }

        if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "E-mail inválido";
            $errors['error'] = true;
        }

        if (empty($data['password'])) {

            $errors['password_error'] = "Digite a senha";
            $errors['error'] = true;
        }

        return ['data' => $data, 'errorData' => $errors];
    }

    public function validateUserCreation()
    {
        $requestParams = RequestData::getRequestParams();

        $data = indexParamExistsOrDefault($requestParams, 'data');
        $errors = indexParamExistsOrDefault($requestParams, 'errors');

        if ($data['password'] && strlen($data['password']) < 6) {

            $errors['password_error'] = "Senha precisa no mínimo de ser maior que 6 caracteres";
            $errors['error'] = true;
        }

        // Password
        if (empty($data['confirm_password'])) {
            $errors['confirm_password_error'] = "Confirme a senha";
            $errors['error'] = true;
        }

        if (!empty($data['password']) && $data['password'] != $data['confirm_password']) {
            $errors['confirm_password_error'] = "Senhas estão diferentes";
            $errors['error'] = true;
        }

        return ['data' => $data, 'errorData' => $errors];
    }

    public function moveUploadImageFolder($data, $lastId = false)
    {
        if ($lastId) $data['id'] = $lastId;

        $id = $data['id'];

        $imgFiles = indexParamExistsOrDefault($data, 'img_files');

        $imgName = indexParamExistsOrDefault($imgFiles, 'name');

        $isEmptyImg = $imgName == "";

        if ($isEmptyImg) return $data;

        $fullPath =
            $this->imagesHandler->imgFolderCreate('users', $id, $imgName);

        $this->imagesHandler->moveUpload($fullPath);

        $data['img_name'] = $imgName;

        return $data;
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

        removeSubmittedFromSession();

        if (!($_SESSION['adm_id'] == 1))  return redirect('users');

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

        // Process Form
        $requestedData = array_merge(
            $this->getRequestData(),
            $this->validateInputsLogin(),
            $this->validateUserCreation()
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        // Find user
        $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data['email']]);

        if ($this->model->rowCount() > 0) {

            $errorData['email_error'] = "Já existe um usuário com esse E-mail";
            $errorData['error'] = true;
        }

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) return $this->create($data, $errorData);

        $_SESSION['submitted'] = true;
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $insertedUser = $this->model->insertUser($data);

        if (!$insertedUser) die('Something went wrong when inserting a user...');

        $flash = flash('register_success', 'Usuário registrado com sucesso!');

        return $this->index(1, $flash);
    }

    public function status($requestData)
    {
        $requestData = array_keys($requestData);

        $id = indexParamExistsOrDefault($requestData, 1);

        if (!$id) die('User id is missing...');

        $status = indexParamExistsOrDefault($requestData, 2);

        $isAdminUser =
            (isset($_SESSION['adm_id']) && $_SESSION['adm_id'] == 1)
            || (isset($_SESSION['user_id'])) && $id == 1;

        if (!$isAdminUser) return redirect('home');

        $this->model->updateStatus($id, $status);

        $message =  ($status == 1)
            ? 'Usuário ativado com sucesso'
            : 'Usuário desativado com sucesso!';

        flash('register_success', $message);

        redirect('users');
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

        $errorData = indexParamExistsOrDefault($requestData, 'error');

        if (!$userId) throw new \Exception('User id is missing...');

        $data = $this->model->getAllFrom('users', $userId);

        $isUserAdminOne = $userId == 1 && $_SESSION['user_id'] == 1;

        $isSameLoggedUser =
            $data->id != 1
            && $_SESSION['user_id'] == $userId
            || $_SESSION['adm_id'] == 1 && $userId != 1;

        if ($isUserAdminOne) {
            View::render('users/edit.php', [
                'title' => 'Editar perfil de ' . $data->name,
                'data' => $data,
                'error' => $errorData
            ]);
        }

        if (!$isUserAdminOne) {

            if (!$isSameLoggedUser) return redirect('users');

            View::render('users/edit.php', [
                'title' => 'Editar perfil de ' . $data->name,
                'data' => $data,
                'error' => $errorData
            ]);
        }
    }

    public function update()
    {
        $this->isLogin();

        // Process Form
        $postResultData = $this->getRequestData();

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $id = $data['id'];

        $isErrorResult = $errorData['error'] == true;


        if ($isErrorResult) {

            return $this->edit([
                'edit' => $id,
                'data' => $data,
                'error' => $errorData
            ]);
        }


        $data = $this->moveUploadImageFolder($data);

        $this->model->updateUser($data);

        $updatedUser = $this->model->rowCount();

        if (!$updatedUser) die('Something went wrong when updating the user...');

        flash('register_success', 'Usuário atualizado com sucesso!');

        return redirect("users/edit/$id/");
    }

    public function blockLoginForDisabledUsers($email)
    {
        $userStatus = $this->model->verifyUserStatus($email);

        $isValidUserStatus = $userStatus == 1;

        if ($isValidUserStatus) return;

        View::render('users/login.php', [
            'error' => [
                'email_error' => 'Usuário está desativado do sistema'
            ]
        ]);

        return exit();
    }

    public function login()
    {
        // if user is already logged redirect to profile
        $sessionUserId =
            indexParamExistsOrDefault($_SESSION, 'user_id');

        if ($sessionUserId) redirect("users/show/$sessionUserId");

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostRequest) {

            return View::render(
                'users/login.php',
                [
                    'title' => 'Users login',
                ]
            );
        }

        // Process Form
        $requestedData = $this->validateInputsLogin();

        $data = indexParamExistsOrDefault($requestedData, 'data');
        $errorData = indexParamExistsOrDefault($requestedData, 'errorData');

        // Don't let users with status 0 login
        if ($data['email'] != '') {

            $this->blockLoginForDisabledUsers($data['email']);
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
        $loggedInUser =
            $this->model->login($data['email'], $data['password']);

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

        flash('register_success', 'Logado com sucesso!');

        redirect('users/show/' . $userId);
    }

    public function logout()
    {
        return $this->model->destroy();
    }
}
