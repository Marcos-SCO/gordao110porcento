<?php

namespace App\Controllers;

use App\Classes\ImagesHandler;
use App\Classes\Pagination;

use App\Request\ImageRequest;
use App\Request\RequestData;
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
        $this->visitingUserRedirect('users');

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

        $activeUsers = Pagination::handler($table, $pageId, $limit = 10, ['status', 1], $orderOption = 'GROUP BY id');

        $inactiveUsers = Pagination::handler($table, $pageId, $limit = 10, ['status', 0], $orderOption = 'GROUP BY id');

        $activeNumber = $this->model->customQuery("SELECT COUNT(*) as active FROM users WHERE status = 1");

        $inactiveNumber = $this->model->customQuery("SELECT COUNT(*) as inactive FROM users WHERE status = 0");

        View::render('users/index.php', [
            'dataPage' => 'users',
            'pageId' => $pageId,
            'title' => 'Users',
            'activeNumber' => $activeNumber,
            'inactiveNumber' => $inactiveNumber,
            'path' => "users",
            'inactiveUsers' => $inactiveUsers['tableResults'],
            'activeUsers' => $activeUsers['tableResults'],
            'prev' => $activeUsers['prev'],
            'next' => $activeUsers['next'],
            'totalResults' => $activeUsers['totalResults'],
            'totalPages' => $activeUsers['totalPages'],
        ]);
    }

    public function create($data = false, $error = false)
    {
        removeSubmittedFromSession();

        $this->ifNotAuthRedirect();

        if (!($_SESSION['adm_id'] == 1)) return redirect('users');

        View::render('users/create.php', [
            'title' => 'Cadastro de usuários',
            'dataPage' => 'users/create',
            'data' => $data,
            'error' => $error
        ]);
    }

    public function store()
    {
        $this->ifNotAuthRedirect();

        $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (isSubmittedInSession() || !$isPostRequest) return redirect('users');

        $requestedData = array_merge(
            UserRequest::nameFieldsValidation(),
            UserRequest::validatePasswords(),
            UserRequest::validateEmailInput(),
            UserRequest::validateUsernameInput(),
        );

        $adm = indexParamExistsOrDefault(UserRequest::getPostData(), 'adm', 0);

        $data = indexParamExistsOrDefault($requestedData, 'data');

        $errorData = indexParamExistsOrDefault($requestedData, 'errorData');

        $getFirstErrorSign = RequestData::isErrorInRequest($errorData);

        if (!$getFirstErrorSign) {

            $errorData = array_merge(
                $errorData,
                UserRequest::emailValidationExistence()['errorData'],
                UserRequest::usernameValidationExistence()['errorData']
            );
        }

        $isErrorResult = $errorData['error'] == true;

        if ($isErrorResult) {

            return $this->create($data, $errorData);
        }

        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        $data['adm'] = $adm;

        $this->visitingUserRedirect('users');

        $insertedUser = $this->model->insertUser($data);

        if (!$insertedUser) die('Something went wrong when inserting a user...');

        flash('register_success', 'Usuário registrado com sucesso!');

        addSubmittedToSession();

        return redirect('users');
    }

    public function show($requestData)
    {
        if (!is_array($requestData)) $requestData = [];

        $username = indexParamExistsOrDefault($requestData, 'user');

        $userPageId = indexParamExistsOrDefault($requestData, 'page', 1);

        $urlPath = "user/$username/page";

        $user = $this->model->getAllFrom('users', $username, 'username');

        if (!$user)  return View::render('errors/404.php');

        // Pagination for posts with user id
        $results = Pagination::handler('posts', $userPageId, $limit = 4, ['user_id', $user->id], $orderOption = 'ORDER BY id DESC');

        // Display results
        $pageInfo = ($userPageId > 1) ? " | Página $userPageId" : '';

        return View::render('users/show.php', [
            'title' => 'Funcionário ' . $user->name . $pageInfo,
            'dataPage' => 'users/show',
            'pageId' => $userPageId,
            'user' => $user,
            'page' => $userPageId,
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

        $postData = UserRequest::getPostData();

        $adm = indexParamExistsOrDefault($postData, 'adm', 0);

        $id = indexParamExistsOrDefault($postData, 'id');

        $bio = indexParamExistsOrDefault($postData, 'bio', '');

        $requestedData = array_merge(
            UserRequest::nameFieldsValidation(),
            UserRequest::validateEmailInput(),
            UserRequest::validateUsernameInput(),
            ImageRequest::validateImageParams(false),
        );

        $data = indexParamExistsOrDefault($requestedData, 'data');

        if ($id) $data['id'] = $id;
        if ($bio || $bio == '') $data['bio'] = $bio;
        $data['adm'] = $adm;

        $errorData =
            indexParamExistsOrDefault($requestedData, 'errorData');

        $notUserIdQuery = "AND id != $id";

        $errorData = array_merge(
            $errorData,
            UserRequest::emailValidationExistence($notUserIdQuery)['errorData'],
            UserRequest::usernameValidationExistence($notUserIdQuery)['errorData'],
        );

        $getFirstErrorSign = UserRequest::isErrorInRequest($errorData);

        if ($getFirstErrorSign) {

            return $this->edit([
                'edit' => $id,
                'data' => $data,
                'error' => $errorData
            ]);
        }

        $this->visitingUserRedirect('users/edit/' . $id);

        $data = $this->moveUploadImageFolder('users', $data);

        $this->model->updateUser($data);

        $updatedUser = $this->model->rowCount();

        if (!$updatedUser) die('Something went wrong when updating the user...');

        flash('register_success', 'Usuário atualizado com sucesso!');

        return redirect("users/edit/$id/");
    }
}
