<?php

namespace App\Models;

use Core\Model;

use Core\View;

class User extends Model
{
    public function getAll()
    {
        $result = $this->selectQuery('users');
        return $result;
    }

    public function getUser($id)
    {
        $result = $this->customQuery(
            "SELECT * FROM users WHERE `id` = :id",
            ['id' => $id]
        );
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
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $lastname = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        $bio = isset($_POST['bio']) ? trim($_POST['bio']) : null;
        $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
        $nameError = isset($_POST['name_error']) ? trim($_POST['name_error']) : '';
        $lastnameError = isset($_POST['last_name_error']) ? trim($_POST['last_name_error']) : '';
        $emailError = isset($_POST['email_error']) ? trim($_POST['email_error']) : '';
        $passwordError = isset($_POST['password_error']) ? trim($_POST['password_error']) : '';
        $confirmPasswordError = isset($_POST['confirm_password_error']) ? trim($_POST['confirm_password_error']) : '';

        $errors = false;

        // Add data to array
        $data = [
            'id' => $id,
            'name' => $name,
            'last_name' => $lastname,
            'email' => $email,
            'password' => $password,
            'bio' => $bio,
            'confirm_password' => $confirmPassword,
            'name_error' => $nameError,
            'last_name_error' => $lastnameError,
            'email_error' => $emailError,
            'password_error' => $passwordError,
            'confirm_password_error' => $confirmPasswordError,
            'errors' => $errors
        ];

        // Name
        if (empty($data['name'])) {
            $data['name_error'] = "Digite o nome";
            $data['errors'] = true;
        }

        if (empty($data['last_name'])) {
            $data['last_name_error'] = "Digite o sobrenome";
            $data['errors'] = true;
        }

        if (isset($_POST['email'])) {
            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = "Digite o E-mail";
                $data['errors'] = true;
            }
            if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                $data['email_error'] = "E-mail inválido";
                $data['errors'] = true;
            }
        }

        // Password validate
        if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
            // Password
            if (empty($data['password'])) {
                $data['password_error'] = "Digite a senha";
                $data['errors'] = true;
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = "Senha precisa no minimo de ser maior que 6 caracteres";
                $data['errors'] = true;
            }
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = "Confirme a senha";
                $data['errors'] = true;
            } elseif ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_error'] = "Senhas estão diferentes";
                $data['errors'] = true;
            }
        }
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
