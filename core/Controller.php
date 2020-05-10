<?php

namespace Core;

// Base controller | Loads the models 
class Controller
{
    // Load Model
    public function model($model)
    {
        $intance = "App\Models\\" . $model;

        // Instantiate model
        return new $intance;
    }
}
