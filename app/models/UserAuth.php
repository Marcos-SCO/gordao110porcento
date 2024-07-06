<?php

namespace App\Models;

use Core\Model;

class UserAuth extends Model
{
    // Login
    public function authenticate($email, $password)
    {
        $result = $this->customQuery("SELECT `status`, `id`, `adm`, `name`, `email`, `password` FROM users WHERE email = :email", ['email' => $email]);

        $hashedPassword = objParamExistsOrDefault($result, 'password');

        $isCorrectPassword =
            password_verify($password, $hashedPassword);

        if (!$isCorrectPassword) return false;

        return $result;
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
    }
}
