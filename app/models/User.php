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

    // update
    public function updateUser($data)
    {
        return $this->updateQuery('users', ['name' => $data['name'], 'last_name' => $data['last_name'], 'img' => $data['img'], 'bio' => $data['bio'], 'updated_at' => date("Y-m-d H:i:s")], ['id', $data['id']]);
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
        $img = isset($_FILES['img']) ? $_FILES['img']['name'] : null;
        $postImg = isset($_POST['img']) ? $_POST['img'] : '';
        $bio = isset($_POST['bio']) ? trim($_POST['bio']) : null;
        $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
        $nameError = isset($_POST['name_error']) ? trim($_POST['name_error']) : '';
        $lastnameError = isset($_POST['last_name_error']) ? trim($_POST['last_name_error']) : '';
        $emailError = isset($_POST['email_error']) ? trim($_POST['email_error']) : '';
        $passwordError = isset($_POST['password_error']) ? trim($_POST['password_error']) : '';
        $confirmPasswordError = isset($_POST['confirm_password_error']) ? trim($_POST['confirm_password_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'name' => $name,
            'last_name' => $lastname,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $confirmPassword,
            'bio' => $bio,
            'img' => $img,
            'post_img' => $postImg,
        ];

        $error = [
            'name_error' => $nameError,
            'last_name_error' => $lastnameError,
            'email_error' => $emailError,
            'password_error' => $passwordError,
            'confirm_password_error' => $confirmPasswordError,
            'error' => false
        ];

        // Name
        if (empty($data['name'])) {
            $error['name_error'] = "Digite o nome";
            $error['errors'] = true;
        }

        if (empty($data['last_name'])) {
            $error['last_name_error'] = "Digite o sobrenome";
            $error['errors'] = true;
        }

        if (isset($_POST['email'])) {
            // Validate Email
            if (empty($data['email'])) {
                $error['email_error'] = "Digite o E-mail";
                $error['errors'] = true;
            }
            if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                $error['email_error'] = "E-mail inválido";
                $error['errors'] = true;
            }
        }

        if (isset($_FILES) && $postImg == '') {
            if (empty($data['img'])) {
                $error['img_error'] = "Insira uma imagem";
                $error['error'] = true;
            }
        }

        // Password validate
        if (isset($_POST['password']) || isset($_POST['confirm_password'])) {
            // Password
            if (empty($data['password'])) {
                $error['password_error'] = "Digite a senha";
                $error['errors'] = true;
            } elseif (strlen($data['password']) < 6) {
                $error['password_error'] = "Senha precisa no minimo de ser maior que 6 caracteres";
                $error['errors'] = true;
            }
            if (empty($data['confirm_password'])) {
                $error['confirm_password_error'] = "Confirme a senha";
                $error['errors'] = true;
            } elseif ($data['password'] != $data['confirm_password']) {
                $error['confirm_password_error'] = "Senhas estão diferentes";
                $error['errors'] = true;
            }
        }
        return [$data, $error];
    }

    public function createUserSession($loggedInUser)
    {
        $_SESSION['user_id'] = $loggedInUser->id;
        $_SESSION['user_email'] = $loggedInUser->email;
        $_SESSION['user_name'] = $loggedInUser->name;
        dump($_SESSION);
    }
}
