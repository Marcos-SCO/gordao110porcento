<?php

namespace App\Controllers;

use App\Request\RequestData;
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

  protected function validateInputsLogin()
  {
    $requestParams = RequestData::getRequestParams();

    $data = indexParamExistsOrDefault($requestParams, 'data', []);
    $errors =
      indexParamExistsOrDefault($requestParams, 'errorData', []);

    // Validate Email
    if (empty($data['email'])) {
      $errors['email_error'] = "Digite o E-mail";
      $errors['error'] = true;
    }

    if (!empty($data['email']) && !filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
      $errors['email_error'] = "E-mail inválido";
      $errors['error'] = true;
    }

    if (empty($data['password'])) {

      $errors['password_error'] = "Digite a senha";
      $errors['error'] = true;
    }

    return ['data' => $data, 'errorData' => $errors];
  }

  protected function validateUserAuthInputs($data)
  {
    // Check an set logged in user
    $authenticatedUser =
      $this->userAuth->authenticate($data['email'], $data['password']);

    $userStatus = objParamExistsOrDefault($authenticatedUser, 'status');

    $data['authenticatedUser'] = $authenticatedUser;

    $errors['error'] = false;

    if (!$authenticatedUser) {

      $errors['error'] = true;
      $errors['password_error'] = "Email ou senha incorretos";
    }

    // Don't let users with status 0 login
    if ($authenticatedUser && $userStatus != 1) {

      $errors['error'] = true;
      $errors['password_error'] = 'Usuário está desativado do sistema';
    }

    return ['data' => $data, 'errorData' => $errors];
  }

  protected function allRequestedForAuthData()
  {
    // Process Form
    $requestedData = $this->validateInputsLogin();

    $data = indexParamExistsOrDefault($requestedData, 'data');
    $errorData = indexParamExistsOrDefault($requestedData, 'errorData');

    $isErrorBeforeAuth = $errorData['error'] == true;

    // User Authentication
    if (!$isErrorBeforeAuth) {

      $authInputData = $this->validateUserAuthInputs($data);

      $data = indexParamExistsOrDefault($authInputData, 'data');

      $errorData =
        indexParamExistsOrDefault($authInputData, 'errorData');
    }

    $isErrorAfterAuth = $errorData['error'] == true;

    if ($isErrorAfterAuth) {

      return View::render('users/login.php', [
        'dataPage' => 'users-login',
        'title' => 'Users Login',
        'data' => $data,
        'error' => $errorData
      ]);
    }

    return ['data' => $data, 'error' => $errorData];
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
