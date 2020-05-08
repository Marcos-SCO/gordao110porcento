<?php

namespace Core;

use PDO;
use PDOException;
use App\Config\Config;

/*
 * PDO Database class
 * Connect to database
 */

abstract class Conn
{
    /**
     * Get the PDO database connection
     * 
     * @return mixed
     */
    protected static function connection()
    {
        // Set dsn
        $dsn = 'mysql:host='.Config::DB_HOST.';port='.Config::DB_PORT.';dbname='.Config::DB_NAME.';charset='.Config::DB_CHARSET;
        $options = [
            PDO::ATTR_PERSISTENT => TRUE,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => FALSE
        ];

        try {
            $pdo = new PDO($dsn, Config::DB_USER, Config::DB_PASS, $options);

            return $pdo = $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
