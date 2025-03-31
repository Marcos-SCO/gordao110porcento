<?php

namespace App\Models;

use Core\Model;

class UserAuth extends Model
{
    // Login
    public function authenticate($userCredential, $password)
    {
        $result = $this->customQuery("SELECT `status`, `id`, `username`, `adm`, `name`, `email`, `password` FROM users WHERE email = :email OR username = :username", ['email' => $userCredential, 'username' => $userCredential]);

        $hashedPassword = objParamExistsOrDefault($result, 'password');

        $isCorrectPassword =
            password_verify($password, $hashedPassword);

        if (!$isCorrectPassword) return false;

        return $result;
    }

    public function createUserSession($loggedInUser)
    {
        $status = objParamExistsOrDefault($loggedInUser, 'status');
        $id = objParamExistsOrDefault($loggedInUser, 'id');
        $adm = objParamExistsOrDefault($loggedInUser, 'adm');
        $email = objParamExistsOrDefault($loggedInUser, 'email');
        $userFirstName = objParamExistsOrDefault($loggedInUser, 'name');
        $username = objParamExistsOrDefault($loggedInUser, 'username');

        $_SESSION['user_status'] = $status;
        $_SESSION['user_id'] = $id;
        $_SESSION['adm_id'] = $adm;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_firstName'] = $userFirstName;
        $_SESSION['username'] = $username;
    }

    public function destroy()
    {
        unset($_SESSION['user_status']);
        unset($_SESSION['user_id']);
        unset($_SESSION['adm_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['username']);
        unset($_SESSION['user_firstName']);

        session_destroy();
    }
}
