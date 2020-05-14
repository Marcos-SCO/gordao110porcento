<?php

namespace App\Models;

class Contact extends \Core\Model
{
    /**
     * Get all the posts as an associative array
     * 
     * @return array
     * 
     */
    public function getAll()
    {
        $result = $this->selectQuery('posts', "ORDER BY id DESC");
        return $result;
    }


    public function getImg($id)
    {
        $result = $this->customQuery(
            "SELECT img FROM posts WHERE `id` = :id",
            ['id' => $id]
        );
        return $result;
    }

    public function addPost($data)
    {
        // dump($data);
        $this->insertQuery('posts', [
            'user_id' => $_SESSION['user_id'],
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img']
        ]);

        // Execute
        if ($this->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($data)
    {
        $this->updateQuery('posts', [
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img']
        ], ['id', $data['id']]);

        // Execute
        if ($this->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($table, $id)
    {
        return $this->deleteQuery($table, $id);
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
        $pdf = isset($_POST['subject']) ? trim($_POST['subject']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $body = isset($_POST['body']) ? trim($_POST['body']) : '';
        $nameError = isset($_POST['name_error']) ? trim($_POST['name_error']) : '';
        $emailError = isset($_POST['email_error']) ? trim($_POST['email_error']) : '';
        $subjectError = isset($_POST['subject_error']) ? trim($_POST['subject_error']) : '';
        $bodyError = isset($_POST['body_error']) ? trim($_POST['body_error']) : '';

        // Add data to array
        $data = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'body' => $body,
        ];

        $error = [
            'name_error' => $nameError,
            'email_error' => $emailError,
            'subject_error' => $subjectError,
            'body_error' => $bodyError,
            'error' => false
        ];

        if (empty($data['name'])) {
            $error['name_error'] = "Informe seu nome.";
            $error['error'] = true;
        }
        if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
            $error['email_error'] = "E-mail inválido";
            $error['error'] = true;
        }
        if (empty($data['email'])) {
            $error['email_error'] = "Digite seu email";
            $error['error'] = true;
        }
        if (empty($data['subject'])) {
            $error['subject_error'] = "Coloque o Assunto.";
            $error['error'] = true;
        }
        if (empty($data['body'])) {
            $error['body_error'] = "Preencha o campo de menssagem.";
            $error['error'] = true;
        }

        return [$data, $error];
    }
}
