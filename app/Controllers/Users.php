<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;
use App\Request\RequestData;
use App\Models\User;
use App\Request\UserValidation;
use Core\Controller;
use Core\View;

class Users extends Controller
{
    public $model;
    public $imagesHandler;
    public $dataPage = 'users';
    public $userAuth;

    public function __construct()
    {
        $this->model = $this->model('User');
        $this->imagesHandler = new ImagesHandler();
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
        removeSubmittedFromSession();

        $this->ifNotAuthRedirect();

        $table = 'users';

        $pageId = isset($requestData['users']) && !empty($requestData['users']) ? $requestData['users'] : 1;

        $results = Pagination::handler($table, $pageId, $limit = 10, '', $orderOption = 'GROUP BY id');

        $activeNumber = $this->model->customQuery("SELECT COUNT(*) as active FROM users WHERE status = 1");

        $inactiveNumber = $this->model->customQuery("SELECT COUNT(*) as inactive FROM users WHERE status = 0");

        View::render('users/index.php', [
            'dataPage' => $this->dataPage,
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
        removeSubmittedFromSession();

        $this->ifNotAuthRedirect();

        if (!($_SESSION['adm_id'] == 1))  return redirect('users');

        View::render('users/create.php', [
            'title' => 'Cadastro de usuários',
            'data' => $data,
            'error' => $error
        ]);
    }

    public function store()
    {
        $this->ifNotAuthRedirect();

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (isSubmittedInSession() || !$isPostRequest) return redirect('users');

        $requestedData = array_merge_recursive(
            UserValidation::nameFieldsValidation(),
            UserValidation::validatePasswords(),
            UserValidation::validateEmailInput(),
        );

        $adm = indexParamExistsOrDefault(UserValidation::getPostData(), 'adm', 0);

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = isset($errorData['error'])
            && array_filter($errorData['error'], function ($item) {
                return $item && $item === true;
            });

        if (!$getFirstErrorSign) {

            $errorData = array_merge($errorData, UserValidation::existenceValidation()['errorData']);
        }

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) {

            return $this->create($data, $errorData);
        }

        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $data['adm'] = $adm;

        $insertedUser = $this->model->insertUser($data);

        if (!$insertedUser) die('Something went wrong when inserting a user...');

        flash('register_success', 'Usuário registrado com sucesso!');

        addSubmittedToSession();

        return redirect('users');
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
        $this->ifNotAuthRedirect();

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
                'dataPage' => 'users/edit',
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
        $this->ifNotAuthRedirect();

        // Process Form
        $postResultData = $this->getRequestData();

        $postResultData =
            ImagesHandler::validateImageParams($postResultData);

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
}
