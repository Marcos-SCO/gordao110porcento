<?php

namespace App\Models;

class Category extends \Core\Model
{
    /**
     * Get all the categories as an associative array
     * 
     * @return array
     * 
     */
    public function getAll()
    {
        $result = $this->selectQuery('categories', "ORDER BY id DESC");
        return $result;
    }


    public function getImg($id)
    {
        $result = $this->customQuery(
            "SELECT img FROM categories WHERE `id` = :id",
            ['id' => $id]
        );

        return $result;
    }

    public function getProducts($id)
    {
        $result = $this->customQuery("SELECT * FROM products WHERE `id_category` = :id_category", ['id_category' => $id], 1);
        return $result;
    }

    public function addCategory($data)
    {
        // dump($data);
        $this->insertQuery('categories', [
            'user_id' => $_SESSION['user_id'],
            'category_name' => $data['category_name'],
            'category_description' => $data['category_description'],
            'img' => $data['img_name'],
            'created_at' => date("Y-m-d H:i:s")
        ]);

        // Execute
        return $this->rowCount();
    }

    public function updateCategory($data)
    {
        $this->updateQuery('categories', [
            'category_name' => $data['category_name'],
            'category_description' => $data['category_description'],
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
