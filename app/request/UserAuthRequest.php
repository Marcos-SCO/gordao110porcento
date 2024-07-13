<?php

namespace App\Request;

use App\Models\UserAuth;

class UserAuthRequest extends RequestData
{

  public static function validateUserAuthLogin($userAuthInstance = false)
  {
    self::$post = self::getPostData();

    self::$data = [];
    self::$errorData = ['error' => false];

    $email = indexParamExistsOrDefault(self::$post, 'email');
    $password = indexParamExistsOrDefault(self::$post, 'password');

    if ($email) self::$data['email'] = trim($email);
    if ($password) self::$data['password'] = trim($password);

    // Check an set logged in user
    $userAuthInstance = $userAuthInstance
      ? $userAuthInstance : new UserAuth();

    $authenticatedUser =
      $userAuthInstance->authenticate(self::$data['email'], self::$data['password']);

    $userStatus = objParamExistsOrDefault($authenticatedUser, 'status');

    self::$data['authenticatedUser'] = $authenticatedUser;

    if (!$authenticatedUser) {
      
      self::$errorData['password_error'] = "Email ou senha incorretos";
    }

    // Don't let users with status 0 login
    if ($authenticatedUser && $userStatus != 1) {

      self::$errorData['password_error'] = 'Usuário está desativado do sistema';
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }

  public static function validateUserAuthInputs()
  {
    self::$post = self::getPostData();

    $email = indexParamExistsOrDefault(self::$post, 'email');
    $password = indexParamExistsOrDefault(self::$post, 'password');

    if ($email) self::$data['email'] = trim($email);
    if ($password) self::$data['password'] = trim($password);

    // Validate Email
    if (empty(self::$data['email'])) {
      self::$errorData['email_error'] = "Digite o E-mail";
    }

    if (!empty(self::$data['email']) && !filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
      self::$errorData['email_error'] = "E-mail inválido";
    }

    if (empty(self::$data['password'])) {

      self::$errorData['password_error'] = "Digite a senha";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
