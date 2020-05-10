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
        // Connection
        $conn = self::connection();

        $stmt = $conn->query('SELECT id, title, content FROM posts ORDER BY created_at');

        $results = $stmt->fetchAll();

        return $results;
    }

    public function addPost($data)
    {
        $this->insertQuery('posts', [
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'body' => $data['body'],
            'img_path' => $data['img_path']
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
            'img_path' => $data['title']
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
        $imgPath = isset($_FILES['img_path']) ? $_FILES['img_path'] : '';
        $userId = isset($_SESSION['user_id']) ? trim($_SESSION['user_id']) : '';
        $titleError = isset($_POST['title_error']) ? trim($_POST['title_error']) : '';
        $bodyError = isset($_POST['body_error']) ? trim($_POST['body_error']) : '';
        $imgPathError = isset($_POST['img_path_error']) ? trim($_POST['img_path_error']) : '';

        // Add data to array
        $data = [
            'title' => $title,
            'body' => $body,
            'img_path' => $imgPath,
            'user_id' => $userId,
            'title_error' => $titleError,
            'body_error' => $bodyError,
            'img_path_error' => $imgPathError,
        ];

        return $data;
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
        if (!file_exists("../public/img/posts/post$tableId")) {
            mkdir("../public/img/posts/post$tableId");
        }
        $picProfile = $table . "_" . $tableId . "_" . $_FILES['img_path']['name'];

        $upload_dir = "img/{$table}/post$tableId/";
        $imgFullPath = $upload_dir . $picProfile;

        return $imgFullPath;
    }
}
