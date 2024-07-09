<?php

namespace App\Controllers;

use App\Models\UserAuth;
use App\Request\RequestData;
use App\Request\UserAuthRequest;
use Core\Controller;
use Core\View;

class UsersAuth extends Controller
{
  public $userModel;
  public $userAuth;
  public $imagesHandler;
  public $dataPage = 'users';

  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->userAuth = $this->model('UserAuth');
  }

  protected function allRequestedForAuthData()
  {
    // Process Form
    $requestedData = UserAuthRequest::validateUserAuthInputs();

    $data = indexParamExistsOrDefault($requestedData, 'data');
    $errorData = indexParamExistsOrDefault($requestedData, 'errorData');

    $getFirstErrorSign = RequestData::isErrorInRequest($errorData);

    if (!$getFirstErrorSign) {

      $authInputData = UserAuthRequest::validateUserAuthLogin($this->userAuth);

      $data = indexParamExistsOrDefault($authInputData, 'data');

      $errorData =
        indexParamExistsOrDefault($authInputData, 'errorData');
    }

    return ['data' => $data, 'errorData' => $errorData];
  }

  public function login()
  {
    // if user is already logged redirect to profile
    $sessionUserId =
      indexParamExistsOrDefault($_SESSION, 'user_id');

    if ($sessionUserId) redirect("users/show/$sessionUserId");

    $isPostRequest = $_SERVER['REQUEST_METHOD'] == 'POST';

    if (!$isPostRequest) {

      return View::render('users/login.php', ['dataPage' => 'users-login', 'title' => 'Users login',]);
    }

    $allRequestedData = $this->allRequestedForAuthData();

    $data = indexParamExistsOrDefault($allRequestedData, 'data');
    $errorData = indexParamExistsOrDefault($allRequestedData, 'errorData');

    $isErrorAfterAuth = RequestData::isErrorInRequest($errorData);

    if ($isErrorAfterAuth) {

      return View::render('users/login.php', [
        'dataPage' => 'users-login',
        'title' => 'Users Login',
        'data' => $data,
        'error' => $errorData
      ]);
    }

    $authenticatedUser =
      indexParamExistsOrDefault($data, 'authenticatedUser');

    $userId = objParamExistsOrDefault($authenticatedUser, 'id');

    // Create user session
    $this->userAuth->createUserSession($authenticatedUser);

    flash('register_success', 'Logado com sucesso!');

    redirect('users/show/' . $userId);
  }

  public function logout()
  {
    $this->userAuth->destroy();

    flash('register_success', 'Você saiu da sessão');

    redirect('login');
  }
}
