<?php

namespace App\Models;

use Core\Model;

use Core\View;

class User extends Model
{
    public function getAll()
    {
        $result = $this->select('users');
        return $result;
    }

    // Login
    public function login($email, $password)
    {
        $result = $this->customQuery("SELECT `id`, `name`, `email`, `password` FROM users WHERE email = :email", ['email' => $email]);

        $hashed_password = $result->password;
        if (password_verify($password, $hashed_password)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
        $nameError = isset($_POST['name_error']) ? trim($_POST['name_error']) : '';
        $emailError = isset($_POST['email_error']) ? trim($_POST['email_error']) : '';
        $passwordError = isset($_POST['password_error']) ? trim($_POST['password_error']) : '';
        $confirmPasswordError = isset($_POST['confirm_password_error']) ? trim($_POST['confirm_password_error']) : '';

        // Add data to array
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $confirmPassword,
            'name_error' => $nameError,
            'email_error' => $emailError,
            'password_error' => $passwordError,
            'confirm_password_error' => $confirmPasswordError
        ];

        return $data;
    }

    public function createUserSession($loggedInUser)
    {
        $_SESSION['user_id'] = $loggedInUser->id;
        $_SESSION['user_email'] = $loggedInUser->email;
        $_SESSION['user_name'] = $loggedInUser->name;
        dump($_SESSION);
    }
}
