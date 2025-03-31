<?php

namespace App\Models;

class Contact extends \Core\Model
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
            'img' => $data['img']
        ]);

        // Execute
        if ($this->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($data)
    {
        $this->updateQuery('posts', [
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img']
        ], ['id', $data['id']]);

        // Execute
        if ($this->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($table, $id)
    {
        return $this->deleteQuery($table, $id);
    }

}
