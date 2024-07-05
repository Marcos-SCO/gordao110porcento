<?php

namespace App\Controllers;

use App\Classes\RequestData;
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
    $this->userModel = $this->model('user');
    $this->userAuth = $this->model('UserAuth');
  }

  // Verifies if a user is login, if not redirect
  public function ifNotAuthRedirect($redirectOption = 'login')
  {
    if (isLoggedIn()) return;

    redirect($redirectOption);
    return exit();
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

  public function blockLoginForDisabledUsers($email)
  {
    $userStatus = $this->userModel->verifyUserStatus($email);

    $isValidUserStatus = $userStatus == 1;

    if ($isValidUserStatus) return;

    View::render('usersAuth/login.php', [
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
          'dataPage' => 'users-login',
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

    $this->userModel->customQuery("SELECT `email` FROM users WHERE `email` = :email", ['email' => $data['email']]);

    // Check for users/email
    if ($_POST['email'] != '' && $this->userModel->rowCount() <= 0) {

      // User not Found
      $errorData['email_error'] = "Nenhum usuário encontrado";
      $errorData['error'] = true;
    }

    $isErrorResult = $errorData['error'] == true;

    if ($isErrorResult) {

      return View::render('users/login.php', [
        'dataPage' => 'users-login',
        'data' => $data,
        'error' => $errorData
      ]);
    }

    // Check an set logged in user
    $loggedInUser =
      $this->userAuth->login($data['email'], $data['password']);

    $userId = objParamExistsOrDefault($loggedInUser, 'id');

    if (!$loggedInUser) {

      $errorData['password_error'] = "Email ou senha incorretos";

      return View::render('users/login.php', [
        'dataPage' => 'users-login',
        'title' => 'Users Login',
        'data' => $data,
        'error' => $errorData
      ]);
    }

    // Create session
    $this->userAuth->createUserSession($loggedInUser);

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
