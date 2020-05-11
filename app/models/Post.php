<?php

namespace App\Models;

class Post extends \Core\Model
{
    /**
     * Get all the posts as an associative array
     * 
     * @return array
     * 
     */
    public static function getAll()
    {
        $result = $this->selectQuery('posts');
        return $result;
    }

    public function getUser($id)
    {
        $result = $this->customQuery(
            "SELECT * FROM users WHERE `id` = :id",
            ['id' => $id]
        );
        return $result;
    }

    public function addPost($data)
    {
        $this->insertQuery('posts', [
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img']
        ]);

        // Execute
        if ($this->model->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($data)
    {
        $this->updateQuery('posts', [
            'title' => $data['title'],
            'body' => $data['title'],
            'img' => $data['title']
        ], ['id', $data['id']]);

        // Execute
        if ($this->model->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $body = isset($_POST['body']) ? trim($_POST['body']) : '';
        $imgPath = isset($_FILES['img']) ? $_FILES['img'] : '';
        $userId = isset($_SESSION['user_id']) ? trim($_SESSION['user_id']) : '';
        $titleError = isset($_POST['title_error']) ? trim($_POST['title_error']) : '';
        $bodyError = isset($_POST['body_error']) ? trim($_POST['body_error']) : '';
        $imgPathError = isset($_POST['img_error']) ? trim($_POST['img_error']) : '';

        // Add data to array
        $data = [
            'title' => $title,
            'body' => $body,
            'img' => $imgPath,
            'user_id' => $userId,
            'title_error' => $titleError,
            'body_error' => $bodyError,
            'img_error' => $imgPathError,
        ];

        if (empty($data['title'])) {
            $data['title_error'] = "Coloque o título.";
            $errors = true;
        }
        if (empty($data['body'])) {
            $data['body_error'] = "Preencha o campo de texto.";
            $errors = true;
        }
        if (empty($data['img'])) {
            $data['img_error'] = "Insira uma imagem";
            $errors = true;
        }

        return $data;
    }

    public function moveUpload()
    {
        if ($data["img"]["tmp_name"] != "") {

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

    public function imgHandler($table)
    {
        $tableId = $this->customQuery("SELECT AUTO_INCREMENT
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = :schema
        AND TABLE_NAME = :table", [
            'schema' => 'db_corte_110porcento',
            'table' => $table
        ]);
        $tableId = strval($tableId->AUTO_INCREMENT);

        // Create post page
        if (!file_exists("../public/img/posts/id_$tableId")) {
            mkdir("../public/img/posts/id_$tableId");
        }
        $picProfile = $table . "_" . $tableId . "_" . $_FILES['img']['name'];

        $upload_dir = "img/{$table}/id_$tableId/";
        $imgFullPath = $upload_dir . $picProfile;

        return $imgFullPath;
    }
}
