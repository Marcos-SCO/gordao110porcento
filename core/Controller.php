<?php

namespace Core;

use App\Config\Config;

// Base controller | Loads the models 
class Controller
{
    // Load Model
    public function model($model)
    {
        $instance = "App\Models\\" . $model;

        // Instantiate model
        return new $instance;
    }

    // Verifies if a user is login, if not redirect
    public function isLogin()
    {
        if (isLoggedIn()) return;

        redirect('login');
        return exit();
    }
   
}
