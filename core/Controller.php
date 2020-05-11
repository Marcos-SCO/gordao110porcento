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

    public function isLogin()
    {
        if (!isLoggedIn()) {
            View::renderTemplate('users/login.html');
            return exit();
        }
    }

    public function moveUpload($imgFullPath)
    {
        if ($_FILES["img"]["tmp_name"] != "") {

            $valid_extensions = ['jpeg', 'jpg', 'png', 'gif', 'pdf'];

            $imgExt = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

            if (in_array($imgExt, $valid_extensions)) {
                move_uploaded_file($_FILES['img']['tmp_name'], $imgFullPath);
            } else {
                $data['img_error'] = "Envie somente Imagens";
                $errors = true;
            }
        } else {
            $data['img_error'] = "Envie uma imagem";
            $errors = true;
        }
    }

    public function imgCreateHandler($table)
    {
        $tableId = $this->model->customQuery("SELECT AUTO_INCREMENT
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = :schema
        AND TABLE_NAME = :table", [
            'schema' => 'db_corte_110porcento',
            'table' => $table
        ]);
        $tableId = strval($tableId->AUTO_INCREMENT);
        return $this->imgFullPath($table, $tableId, $_FILES['img']['name']);
    }

    public function imgFullPath($table, $id, $imgName)
    {
        if (file_exists("../public/img/{$table}/id_$id")) {
            array_map('unlink', glob("../public/img/{$table}/id_{$id}/*.*"));
            rmdir("../public/img/{$table}/id_$id");
        }
        // Create post page
        if (!file_exists("../public/img/{$table}/id_$id")) {
            mkdir("../public/img/{$table}/id_$id");
        }
        $picProfile = $imgName;

        $upload_dir = "img/{$table}/id_$id/";
        $imgFullPath = $upload_dir . $picProfile;

        return $imgFullPath;
    }
}
