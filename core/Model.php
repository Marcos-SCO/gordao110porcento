<?php

namespace Core;

class Model extends Conn
{
    public $conn;
    public $stmt;

    public function __construct()
    {
        $this->conn = Conn::connection();
    }

    // Bind values
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }

        return $this->stmt->bindValue($param, $value, $type);
    }

    public function selectQuery($table, $option = '')
    {
        $query = "SELECT * FROM {$table}";
        if ($option != '') {
            $query .= " {$option}";
        }
        $this->stmt = $this->conn->prepare($query);
        $this->stmt->execute();
        $result = $this->stmt->fetchAll();
        $this->stmt->closeCursor();
        return $result;
    }

    public function insertQuery($table, array $data)
    {
        $fields = implode(',', array_keys($data));
        $places = ':' . implode(',:', array_keys($data));

        $query = "INSERT INTO {$table} ({$fields}) VALUES ({$places})";

        $this->stmt = $this->conn->prepare($query);
        foreach ($data as $name => $value) {
            $this->bind(":{$name}", $value);
        }
        $this->stmt->execute();
        $this->stmt->closeCursor();
        return $this->conn->lastInsertId();
    }

    public function updateQuery($table, array $data, array $id)
    {
        // Destruct id
        list($idKey, $idVal) = $id;

        $query = "UPDATE {$table} SET";
        foreach ($data as $field => $value) {
            $query .= " {$field} = :{$field},";
        }
        $query = rtrim($query, ",");
        $query .= " WHERE {$idKey} = :{$idKey}";
        $this->stmt = $this->conn->prepare($query);
        foreach ($data as $field => $value) {
            $this->bind(":{$field}", $value);
        }
        // dump($query);
        $this->bind(":{$idKey}", $idVal);
        // Bind id values
        $this->stmt->execute();
        $result = $this->stmt->fetch();
        $this->stmt->closeCursor();
        return $result;
    }

    public function deleteQuery($table, array $data)
    {
        $query = "DELETE FROM {$table} WHERE";
        
        foreach ($data as $field => $value) {
            $query .= " {$field} = :{$field} AND";
        }
        $query = rtrim($query, "AND");
        // dump($query);
        $this->stmt = $this->conn->prepare($query);
        foreach ($data as $field => $value) {
            $this->bind(":{$field}", $value);
        }
        $this->stmt->execute();
        $result = $this->stmt->fetch();
        $this->stmt->closeCursor();
        return $result;
    }

    public function customQuery($query, array $data = null)
    {
        $this->stmt = $this->conn->prepare($query);
        if ($data) {
            foreach ($data as $field => $value) {
                $this->bind(":{$field}", $value);
            }
        }
        // dump($query);
        $this->stmt->execute();
        $result = $this->stmt->fetch();
        $this->stmt->closeCursor();
        return $result;
    }

    // Get all from with id
    public function getAllFrom($table, $id, $optionId = 'id')
    {
    $result = $this->customQuery("SELECT * FROM $table WHERE `{$optionId}` = :{$optionId}",["{$optionId}" => $id]);
        return $result;
    }

    // Get row count
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    public function lastId()
    {
        return $this->conn->lastInsertId();
    }
}
