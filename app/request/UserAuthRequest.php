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

    $userCredential = indexParamExistsOrDefault(self::$post, 'userCredential');

    $password = indexParamExistsOrDefault(self::$post, 'password');

    if ($userCredential) self::$data['userCredential'] = trim($userCredential);

    if ($password) self::$data['password'] = trim($password);

    // Check an set logged in user
    $userAuthInstance = $userAuthInstance
      ? $userAuthInstance : new UserAuth();

    $authenticatedUser =
      $userAuthInstance->authenticate(self::$data['userCredential'], self::$data['password']);

    $userStatus = objParamExistsOrDefault($authenticatedUser, 'status');

    self::$data['authenticatedUser'] = $authenticatedUser;

    if (!$authenticatedUser) {

      self::$errorData['password_error'] = "Usuário ou senha incorretos";
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

    $userCredential = indexParamExistsOrDefault(self::$post, 'userCredential');

    $password = indexParamExistsOrDefault(self::$post, 'password');

    if ($userCredential) self::$data['userCredential'] = trim($userCredential);

    if ($password) self::$data['password'] = trim($password);

    // Validate userCredential
    if (empty(self::$data['userCredential'])) {
      self::$errorData['userCredential_error'] = "Digite usuário ou e-mail";
    }

    if (empty(self::$data['password'])) {

      self::$errorData['password_error'] = "Digite a senha";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
