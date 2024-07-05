<?php

namespace Core;

use App\Config\Config;
use App\Controllers\UsersAuth;
use App\Models\UserAuth;

// Base controller | Loads the models 
class Controller
{
    public $usersAuth;

    public function __construct()
    {
        $this->usersAuth = new UsersAuth();
    }

    // Load Model
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
}
