<?php

namespace App\Models;

class Gallery extends \Core\Model
{
    /**
     * Get all the gallery as an associative array
     * 
     * @return array
     * 
     */
    public function getAll()
    {
        $result = $this->selectQuery('gallery', "ORDER BY id DESC");
        return $result;
    }

    public function getImg($id)
    {
        $result = $this->customQuery(
            "SELECT img FROM gallery WHERE `id` = :id",
            ['id' => $id]
        );

        return $result;
    }

    public function addImg($data)
    {
        // dump($data);
        $this->insertQuery('gallery', [
            'user_id' => $_SESSION['user_id'],
            'img_title' => $data['img_title'],
            'img' => $data['img_name'],
            'created_at' => date("Y-m-d H:i:s")
        ]);

        // Execute
        return $this->rowCount();
    }

    public function updateImg($data)
    {
        $this->updateQuery('gallery', [
            'img_title' => $data['img_title'],
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
