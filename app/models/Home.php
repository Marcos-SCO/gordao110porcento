<?php

namespace App\Models;

use Core\Model;

abstract class Home extends Model
{
    public function getAll()
    {
        $result = $this->select('users');
        return $result;
    }
}
