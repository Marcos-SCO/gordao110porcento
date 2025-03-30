<?php

namespace Core;

use App\Config\Config;
use App\Controllers\UsersAuth;
use App\Models\UserAuth;

// Base controller | Loads the models 
class Controller
{
    // Instantiate Model
    public function model($model)
    {
        $instance = "App\Models\\" . $model;

        // Instantiate model
        return new $instance;
    }

    // Verifies if a user is login, if not redirect
    public function ifNotAuthRedirect($redirectOption = 'login')
    {
        if (isLoggedIn()) return;

        redirect($redirectOption);
        return exit();
    }

    public function visitingUserRedirect($redirectTo = 'home')
    {
        $userName = isset($_SESSION['username'])
            ? $_SESSION['username'] : false;

        $isVisitingUserName = $userName == 'visitinguser';
        if (!$isVisitingUserName) return;

        flash('register_success', "Usuário visitante não pode alterar coisas</br> (Visiting user can't change things)");

        return redirect($redirectTo);
    }
}
