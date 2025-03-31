<?php

namespace App\Models;

class ProductCategory extends \Core\Model
{
    /**
     * Get all the categories as an associative array
     * 
     * @return array
     * 
     */
    public function getAll()
    {
        $result = $this->selectQuery('product_categories', "ORDER BY id DESC");
        return $result;
    }

    public static function getCategories($selectParams = 'slug, category_name, id')
    {
        $self = new self();
        $result = $self->selectQuery('product_categories', '', $selectParams);

        $categories = [];
        foreach ($result as $row) {

            $categories[$row->id] = ['slug' => $row->slug, 'category_name' => $row->category_name, 'id' => $row->id];
        }

        return $categories;
    }

    public function getImg($id)
    {
        $result = $this->customQuery(
            "SELECT img FROM product_categories WHERE `id` = :id",
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
        $this->insertQuery('product_categories', [
            'user_id' => $_SESSION['user_id'],
            'slug' => $data['category_slug'],
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
        $this->updateQuery('product_categories', [
            'slug' => $data['category_slug'],
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
