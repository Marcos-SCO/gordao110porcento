<?php

namespace App\Request;

use App\Models\User;

class UserRequest extends RequestData
{

  public static function nameFieldsValidation()
  {
    self::$post = self::getPostData();

    $name = indexParamExistsOrDefault(self::$post, 'name');
    $lastName = indexParamExistsOrDefault(self::$post, 'last_name');

    if ($name) self::$data['name'] = $name;
    if ($lastName) self::$data['last_name'] = $lastName;

    if (empty($name)) {

      self::$errorData['name_error'] = "Digite o nome";
    }

    if (empty($lastName)) {

      self::$errorData['last_name_error'] = "Digite o sobrenome";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }

  public static function validatePasswords()
  {
    self::$post = self::getPostData();

    $password = verifyValue(self::$post, 'password');

    $confirmPassword =
      indexParamExistsOrDefault(self::$post, 'confirm_password', '');

    if ($password) self::$data['password'] = $password;
    if ($confirmPassword) self::$data['confirm_password'] = $confirmPassword;

    if (empty($password)) {

      self::$errorData['password_error'] = "Digite a senha";
    }

    if ($password && strlen($password) < 6) {

      self::$errorData['password_error'] = "Senha precisa no mínimo de ser maior que 6 caracteres";
    }

    // Password
    if (empty($confirmPassword)) {

      self::$errorData['confirm_password_error'] = "Confirme a senha";
    }

    if (!empty($password) && $password != $confirmPassword) {

      self::$errorData['confirm_password_error'] = "Senhas estão diferentes";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }

  public static function validateUsernameInput($requestData = false)
  {
    self::$post = self::getPostData();
    if (!self::$post) return;

    $username = indexParamExistsOrDefault(self::$post, 'username');

    if ($username) self::$data['username'] = mb_strtolower($username);

    if (empty($username)) {

      self::$errorData['username_error'] = "Digite o username";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }

  public static function usernameValidationExistence($queryOption = false)
  {
    self::$post = self::getPostData();

    $username = indexParamExistsOrDefault(self::$post, 'username');

    $userExistsData = User::verifyIFExistsWith(['username' => $username], $queryOption);

    if ($userExistsData) {

      self::$errorData['username_error'] = "Já existe um usuário com esse username";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }

  public static function validateEmailInput($requestData = false)
  {
    self::$post = self::getPostData();
    if (!self::$post) return;

    $email = indexParamExistsOrDefault(self::$post, 'email');

    if ($email) self::$data['email'] = $email;

    $isValidEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (empty($email)) {

      self::$errorData['email_error'] = "Digite o E-mail";
    }

    if (!empty($email) && !$isValidEmail) {

      self::$errorData['email_error'] = "E-mail inválido";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }

  public static function emailValidationExistence($queryOption = false)
  {
    self::$post = self::getPostData();

    $email = indexParamExistsOrDefault(self::$post, 'email');

    $userExistsData = User::verifyIFExistsWith(['email' => $email], $queryOption);

    if ($userExistsData) {

      self::$errorData['email_error'] = "Já existe um usuário com esse e-mail";
    }

    if (count(self::$errorData) > 1) self::$errorData['error'] = true;

    return ['data' => self::$data, 'errorData' => self::$errorData];
  }
}
