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

        $hashedPassword = $result->password;

        $isCorrectPassword =
            password_verify($password, $hashedPassword);

        if (!$isCorrectPassword) return false;

        return $result;
    }

    // insert
    public function insertUser($data)
    {
        return $this->insertQuery('users', ['adm' => $data['adm'], 'name' => $data['name'], 'last_name' => $data['last_name'], 'email' => $data['email'], 'password' => $data['password'], 'created_at' => date("Y-m-d H:i:s")]);
    }

    // update
    public function updateUser($data)
    {

        $userId = indexParamExistsOrDefault($data, 'id');

        return $this->updateQuery(
            'users',
            [
                'adm' => $data['adm'],
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'img' => $data['img_name'],
                'bio' => $data['bio'],
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id', intval($userId)
            ]
        );
    }

    public function updateStatus($id, $status)
    {
        return $this->updateQuery('users', ['status' => $status], ['id', $id]);
    }

    public function verifyUserStatus($email)
    {
        $userQueryStatus = $this->customQuery("SELECT `status` FROM users WHERE `email` = :email", ['email' => $email]);

        $userStatus = objParamExistsOrDefault($userQueryStatus, 'status');

        return $userStatus;
    }

    public function createUserSession($loggedInUser)
    {
        $_SESSION['user_status'] = $loggedInUser->status;
        $_SESSION['user_id'] = $loggedInUser->id;
        $_SESSION['adm_id'] = $loggedInUser->adm;
        $_SESSION['user_email'] = $loggedInUser->email;
        $_SESSION['user_name'] = $loggedInUser->name;
    }

    public function destroy()
    {
        unset($_SESSION['user_status']);
        unset($_SESSION['user_id']);
        unset($_SESSION['adm_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();

        redirect('login');
    }
}
