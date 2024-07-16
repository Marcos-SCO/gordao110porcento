<?php

namespace App\Models;

class Product extends \Core\Model
{
    /**
     * Get all the products as an associative array
     * 
     * @return array
     * 
     */
    public function getAll()
    {
        $result = $this->selectQuery('products', "ORDER BY id DESC");
        return $result;
    }

    public function getCategories()
    {
        $result = $this->customQuery("SELECT id, category_name FROM product_categories ORDER BY id DESC", null, 1);
        
        return $result;
    }

    public function getProduct($id, $idCategory)
    {
        $result = $this->customQuery("SELECT id, id_category FROM products WHERE id = :id AND id_category = :id_category", ['id' => $id, 'id_category' => $idCategory]);

        return $result;
    }

    public function getProductId($id)
    {
        $result = $this->customQuery("SELECT id, id_category FROM products WHERE id = :id", ['id' => $id]);

        return $result;
    }


    public function getImg($id)
    {
        $result = $this->customQuery(
            "SELECT img FROM products WHERE `id` = :id",
            ['id' => $id]
        );

        return $result;
    }

    public function addProduct($data)
    {
        // dump($data);
        $this->insertQuery('products', [
            'slug' => $data['product_slug'],
            'user_id' => $_SESSION['user_id'],
            'id_category' => $data['product_id_category'],
            'product_name' => $data['product_name'],
            'product_description' => $data['product_description'],
            'img' => $data['img_name'],
            'price' => $data['price'],
            'created_at' => date("Y-m-d H:i:s")
        ]);

        // Execute
        if (!$this->rowCount()) return false;

        return true;
    }

    public function updateProduct($data)
    {
        $this->updateQuery('products', [
            'slug' => $data['product_slug'],
            'id_category' => $data['product_id_category'],
            'product_name' => $data['product_name'],
            'product_description' => $data['product_description'],
            'img' => $data['img_name'],
            'price' => $data['price'],
            'updated_at' => date("Y-m-d H:i:s")
        ], ['id', $data['id']]);

        // Execute
        if (!$this->rowCount()) return false;

        return true;
    }

    public function deleteProduct($table, $id)
    {
        return $this->deleteQuery($table, $id);
    }
}
