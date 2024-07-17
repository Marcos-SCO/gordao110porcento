<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    public function getAll()
    {
        $result = $this->selectQuery('users', 'ORDER BY id AND status DESC');

        return $result;
    }

    // insert
    public function insertUser($data)
    {
        return $this->insertQuery('users', [
            'adm' => $data['adm'],
            'username' => $data['username'],
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'created_at' => date("Y-m-d H:i:s")
        ]);
    }

    // update
    public function updateUser($data)
    {

        $userId = indexParamExistsOrDefault($data, 'id');

        return $this->updateQuery(
            'users',
            [
                'adm' => $data['adm'],
                'username' => $data['username'],
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'img' => $data['img_name'],
                'bio' => $data['bio'],
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id', intval($userId)
            ]
        );
    }

    public function updateStatus($id, $status)
    {
        return $this->updateQuery('users', ['status' => $status], ['id', $id]);
    }

    public function verifyUserStatus($email)
    {
        $userQueryStatus = $this->customQuery("SELECT `status` FROM users WHERE `email` = :email", ['email' => $email]);

        $userStatus = objParamExistsOrDefault($userQueryStatus, 'status');

        return $userStatus;
    }

    public static function verifyIFExistsWith(array $userParams = [], $queryOptions = false)
    {
        $queryParams = "WHERE";

        foreach ($userParams as $key => $value) {
            $value = is_string($value) ? '\'' . $value . '\'' : $value;

            $queryParams .= " $key = {$value},";
        }

        $queryParams = rtrim($queryParams, ',');

        if ($queryOptions) $queryParams .= ' ' . $queryOptions;

        $self = new self();
        $self->selectQuery('users', $queryParams, 'email');
        // $self->selectQuery('users', $queryOption);

        return $self->rowCount() > 0;
    }
}
