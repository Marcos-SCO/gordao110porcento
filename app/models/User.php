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
        return $this->insertQuery('users', ['adm' => $data['adm'], 'name' => $data['name'], 'last_name' => $data['last_name'], 'email' => $data['email'], 'password' => $data['password'], 'created_at' => date("Y-m-d H:i:s")]);
    }

    // update
    public function updateUser($data)
    {

        $userId = indexParamExistsOrDefault($data, 'id');

        return $this->updateQuery(
            'users',
            [
                'adm' => $data['adm'],
                'name' => $data['name'],
                'last_name' => $data['last_name'],
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
}
