<?php

namespace App\Models;

use Core\Model;

use Core\View;

class User extends Model
{
    public function getAll()
    {
        $result = $this->selectQuery('users', 'ORDER BY id AND status DESC');
        return $result;
    }

    // Login
    public function login($email, $password)
    {
        $result = $this->customQuery("SELECT `status`, `id`, `adm`, `name`, `email`, `password` FROM users WHERE email = :email", ['email' => $email]);
        $hashed_password = $result->password;
        if (password_verify($password, $hashed_password)) {
            return $result;
        } else {
            return false;
        }
    }

    // insert
    public function insertUser($data)
    {
        return $this->insertQuery('users', ['adm' => $data['adm'], 'name' => $data['name'], 'last_name' => $data['last_name'], 'email' => $data['email'], 'password' => $data['password'], 'created_at' => date("Y-m-d H:i:s")]);
    }

    // update
    public function updateUser($data)
    {
        return $this->updateQuery('users', ['adm' => $data['adm'], 'name' => $data['name'], 'last_name' => $data['last_name'], 'img' => $data['img'], 'bio' => $data['bio'], 'updated_at' => date("Y-m-d H:i:s")], ['id', $data['id']]);
    }

    public function updateStatus($id, $status)
    {
        return $this->updateQuery('users', ['status' => $status], ['id', $id]);
    }

    public function blockLogin($email)
    {
        $status = $this->customQuery("SELECT `status` FROM users WHERE `email` = :email", ['email' => $email]);
        if ($status->status < 1) {
            $error['email_error'] = 'Usuário está desativado do sistema';
            View::renderTemplate('users/login.html', [
                'error' => $error
            ]);
            return exit();
        }
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $adm = isset($_POST['adm']) ? intval(trim($_POST['adm'])) : 0;
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
            'adm' => $adm,
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

        if (isset($_POST['name']) || isset($_POST['last_name'])) {
            // Name
            if (empty($data['name'])) {
                $error['name_error'] = "Digite o nome";
                $error['error'] = true;
            }
            if (empty($data['last_name'])) {
                $error['last_name_error'] = "Digite o sobrenome";
                $error['error'] = true;
            }
        }

        if (isset($_POST['email']) != '') {
            // Validate Email
            if (empty($data['email'])) {
                $error['email_error'] = "Digite o E-mail";
                $error['error'] = true;
            }
            if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                $error['email_error'] = "E-mail inválido";
                $error['error'] = true;
            }
        }

        if (isset($_FILES['img']) && $postImg == '') {
            if (empty($data['img'])) {
                $error['img_error'] = "Insira uma imagem";
                $error['error'] = true;
            }
        }

        if (isset($_POST['password'])) {
            if (empty($data['password'])) {
                $error['password_error'] = "Digite a senha";
                $error['error'] = true;
            } elseif (strlen($data['password']) < 6) {
                $error['password_error'] = "Senha precisa no minimo de ser maior que 6 caracteres";
                $error['error'] = true;
            }
        }
        // Password validate
        if (isset($_POST['confirm_password'])) {
            // Password
            if (empty($data['confirm_password'])) {
                $error['confirm_password_error'] = "Confirme a senha";
                $error['error'] = true;
            } elseif ($data['password'] != $data['confirm_password']) {
                $error['confirm_password_error'] = "Senhas estão diferentes";
                $error['error'] = true;
            }
        }
        return [$data, $error];
    }

    public function createUserSession($loggedInUser)
    {
        $_SESSION['user_status'] = $loggedInUser->status;
        $_SESSION['user_id'] = $loggedInUser->id;
        $_SESSION['adm_id'] = $loggedInUser->adm;
        $_SESSION['user_email'] = $loggedInUser->email;
        $_SESSION['user_name'] = $loggedInUser->name;
        dump($_SESSION);
    }
}
