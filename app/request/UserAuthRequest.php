<?php

namespace App\Request;

use App\Models\UserAuth;

class UserAuthRequest extends RequestData
{

  public static function validateUserAuthLogin($userAuthInstance = false)
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $email = indexParamExistsOrDefault($post, 'email');
    $password = indexParamExistsOrDefault($post, 'password');

    if ($email) $data['email'] = trim($email);
    if ($password) $data['password'] = trim($password);

    // Check an set logged in user
    $userAuthInstance = $userAuthInstance
      ? $userAuthInstance : new UserAuth();

    $authenticatedUser =
      $userAuthInstance->authenticate($data['email'], $data['password']);

    $userStatus = objParamExistsOrDefault($authenticatedUser, 'status');

    $data['authenticatedUser'] = $authenticatedUser;

    if (!$authenticatedUser) {
      
      $errorData['password_error'] = "Email ou senha incorretos";
    }

    // Don't let users with status 0 login
    if ($authenticatedUser && $userStatus != 1) {

      $errorData['password_error'] = 'Usuário está desativado do sistema';
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }

  public static function validateUserAuthInputs()
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $email = indexParamExistsOrDefault($post, 'email');
    $password = indexParamExistsOrDefault($post, 'password');

    if ($email) $data['email'] = trim($email);
    if ($password) $data['password'] = trim($password);

    // Validate Email
    if (empty($data['email'])) {
      $errorData['email_error'] = "Digite o E-mail";
    }

    if (!empty($data['email']) && !filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
      $errorData['email_error'] = "E-mail inválido";
    }

    if (empty($data['password'])) {

      $errorData['password_error'] = "Digite a senha";
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }
}
