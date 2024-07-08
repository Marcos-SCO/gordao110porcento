<?php

namespace App\Request;

use App\Models\User;

class UserRequest extends RequestData
{

  public static function nameFieldsValidation()
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $name = indexParamExistsOrDefault($post, 'name');
    $lastName = indexParamExistsOrDefault($post, 'last_name');

    if ($name) $data['name'] = $name;
    if ($lastName) $data['last_name'] = $lastName;

    if (empty($name)) {

      $errorData['name_error'] = "Digite o nome";
    }

    if (empty($lastName)) {

      $errorData['last_name_error'] = "Digite o sobrenome";
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }

  public static function validatePasswords()
  {
    $post = self::getPostData();

    $data = [];
    $errorData = ['error' => false];

    $password = verifyValue($post, 'password');

    $confirmPassword =
      indexParamExistsOrDefault($post, 'confirm_password', '');

    if ($password) $data['password'] = $password;
    if ($confirmPassword) $data['confirm_password'] = $confirmPassword;

    if (empty($password)) {

      // $errorData['error'] = true;
      $errorData['password_error'] = "Digite a senha";
    }

    if ($password && strlen($password) < 6) {

      // $errorData['error'] = true;
      $errorData['password_error'] = "Senha precisa no mínimo de ser maior que 6 caracteres";
    }

    // Password
    if (empty($confirmPassword)) {

      // $errorData['error'] = true;
      $errorData['confirm_password_error'] = "Confirme a senha";
    }

    if (!empty($password) && $password != $confirmPassword) {

      // $errorData['error'] = true;
      $errorData['confirm_password_error'] = "Senhas estão diferentes";
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }

  public static function existenceValidation()
  {
    $post = self::getPostData();

    $email = indexParamExistsOrDefault($post, 'email');

    $userExistsData = User::verifyIFExistsWith(['email' => $email]);

    $data = [];
    $errorData = ['error' => false];

    if ($userExistsData) {

      $errorData['email_error'] = "Já existe um usuário com esse E-mail";
      // $errorData['error'] = true;
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }

  public static function validateEmailInput($requestData = false)
  {
    $post = self::getPostData();
    if (!$post) return;

    $email = indexParamExistsOrDefault($post, 'email');

    $data = [];
    $errorData = ['error' => false];

    if ($email) $data['email'] = $email;

    $isValidEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (empty($email)) {

      // $errorData['error'] = true;
      $errorData['email_error'] = "Digite o E-mail";
    }

    if (!empty($email) && !$isValidEmail) {

      // $errorData['error'] = true;
      $errorData['email_error'] = "E-mail inválido";
    }

    if (count($errorData) > 1) $errorData['error'] = true;

    return ['data' => $data, 'errorData' => $errorData];
  }
}
