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
}
