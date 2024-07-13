<?php

namespace App\Models;

use Core\Model;

class About extends Model
{
    public function getAll()
    {
    }

    public function getPosts()
    {
        return $this->selectQuery("posts", "ORDER BY id DESC LIMIT 10");
    }

    public function getProducts($id_category)
    {
        return $this->selectQuery("products", "WHERE id_category = {$id_category} ORDER BY id DESC LIMIT 8");
    }

    public function getCategories()
    {
        return $this->selectQuery("product_categories", "ORDER BY id DESC");
    }
}
