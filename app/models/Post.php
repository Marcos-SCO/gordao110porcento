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
    public function getAll()
    {
        $result = $this->selectQuery('posts', "ORDER BY id DESC");
        return $result;
    }


    public function getImg($id)
    {
        $result = $this->customQuery(
            "SELECT img FROM posts WHERE `id` = :id",
            ['id' => $id]
        );
        return $result;
    }

    public function addPost($data)
    {
        // dump($data);
        $this->insertQuery('posts', [
            'user_id' => $_SESSION['user_id'],
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img_name']
        ]);

        // Execute
        return $this->rowCount();
    }

    public function updatePost($data)
    {
        $this->updateQuery('posts', [
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img_name'],
            'updated_at' => date("Y-m-d H:i:s")
        ], ['id', $data['id']]);

        // Execute
        return $this->rowCount();
    }

    public function deletePost($table, $id)
    {
        return $this->deleteQuery($table, $id);
    }
}
