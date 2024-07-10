<?php

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;

use App\Request\ImageRequest;
use App\Request\UserRequest;

use App\Traits\GeneralImagesHandlerTrait;

use Core\Controller;
use Core\View;

class Users extends Controller
{
    use GeneralImagesHandlerTrait;

    public $model;
    public $imagesHandler;
    public $dataPage = 'users';

    public function __construct()
    {
        $this->model = $this->model('User');
        $this->imagesHandler = new ImagesHandler();
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
            UserRequest::nameFieldsValidation(),
            UserRequest::validatePasswords(),
            UserRequest::validateEmailInput(),
        );

        $adm = indexParamExistsOrDefault(UserRequest::getPostData(), 'adm', 0);

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = isset($errorData['error'])
            && array_filter($errorData['error'], function ($item) {
                return $item && $item === true;
            });

        if (!$getFirstErrorSign) {

            $errorData = array_merge($errorData, UserRequest::existenceValidation()['errorData']);
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

    public function show($requestData)
    {
        if (!is_array($requestData)) $requestData = [];

        $userPageId = isset($requestData['show']) && !empty($requestData['show']) ? $requestData['show'] : 1;

        $urlPath = "users/show/$userPageId";

        $lastKey = array_key_last($requestData);
        
        $pageId = !($lastKey == 'show') ? end($requestData) : 1;

        if ($userPageId && ($lastKey == 'show')) $pageId = $userPageId;

        $user = $this->model->getAllFrom('users', $userPageId);

        // Pagination for posts with user id
        $results = Pagination::handler('posts', $pageId, $limit = 4, ['user_id', $user->id], $orderOption = 'ORDER BY id DESC');

        // Display results
        $pageInfo = ($userPageId > 1) ? " | Página $userPageId" : '';

        return View::render('users/show.php', [
            'title' => 'Funcionário ' . $user->name . $pageInfo,
            'pageId' => $pageId,
            'user' => $user,
            'page' => $pageId,
            'path' => $urlPath,
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

        if (!$isUserAdminOne) {

            if (!$isSameLoggedUser) return redirect('users');
        }

        View::render('users/edit.php', [
            'title' => 'Editar perfil de ' . $data->name,
            'dataPage' => 'users/edit',
            'data' => $data,
            'error' => $errorData
        ]);
    }

    public function update()
    {
        $this->ifNotAuthRedirect();

        $adm = indexParamExistsOrDefault(UserRequest::getPostData(), 'adm', 0);

        $id = indexParamExistsOrDefault(UserRequest::getPostData(), 'id');

        $bio = indexParamExistsOrDefault(UserRequest::getPostData(), 'bio', '');

        $requestedData = array_merge_recursive(
            UserRequest::nameFieldsValidation(),
            ImageRequest::validateImageParams(false),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        if ($id) $data['id'] = $id;
        if ($bio || $bio == '') $data['bio'] = $bio;
        $data['adm'] = $adm;

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = isset($errorData['error'])
            && array_filter($errorData['error'], function ($item) {
                return $item && $item === true;
            });

        if ($getFirstErrorSign) {

            return $this->edit([
                'edit' => $id,
                'data' => $data,
                'error' => $errorData
            ]);
        }

        $data = $this->moveUploadImageFolder('users', $data);

        $this->model->updateUser($data);

        $updatedUser = $this->model->rowCount();

        if (!$updatedUser) die('Something went wrong when updating the user...');

        flash('register_success', 'Usuário atualizado com sucesso!');

        return redirect("users/edit/$id/");
    }
}
