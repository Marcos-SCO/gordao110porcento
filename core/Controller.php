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
}
