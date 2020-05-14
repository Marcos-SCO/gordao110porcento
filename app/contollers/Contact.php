<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Config\Config;

class Contact extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Contact');
    }

    public function index($type = null)
    {
        if ($type == 'message') {
            return $this->message();
        } else if ($type == 'work') {
            return $this->work();
        } else {
            return redirect('home');
        }
    }
    public function success()
    {
        View::renderTemplate('contact/success.html', [
            'title' => 'Sua menssagem foi enviada com sucesso!',
        ]);
    }

    public function message($data = null, $error = null, $flash = null)
    {
        if (isset($_SESSION['submitted'])) {
            unset($_SESSION['submitted']);
        }
        View::renderTemplate('contact/message.html', [
            'title' => 'Contato - envie sua menssagem',
            'data' => $data,
            'error' => $error,
            'flash' => $flash
        ]);
    }
    public function work($data = null, $error = null, $flash = null)
    {
        if (isset($_SESSION['submitted'])) {
            unset($_SESSION['submitted']);
        }
        View::renderTemplate('contact/work.html', [
            'title' => 'Envie sua mensagem com um anexo',
            'data' => $data,
            'error' => $error,
            'flash' => $flash
        ]);
    }

    public function messageSend()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['submitted'])) {
            $result = $this->getPostData();
            $data = $result[0];
            $error = $result[1];
            // Validate data
            if ($error['error'] != true) {
                $_SESSION['submitted'] = true;
                $this->sendEmailHandler($data);
                return redirect('contact/success');
            } else {
                return $this->message($data, $error);
            }
        }
    }

    public function workSend()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['submitted'])) {
            $result = $this->getPostData();
            $data = $result[0];
            $error = $result[1];

            // Validate data
            if ($error['error'] != true) {
                $flash = flash('post_message', 'Menssagem Enviada com sucesso');
                $this->sendEmailHandler($data, $data['attachment']);
                return redirect('contact/success');
            } else {
                $data['attachment'] = $_FILES["attachment"]['tmp_name'];
                //dump($data);
                return $this->work($data, $error);
            }
        }
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
        $attachment = isset($_FILES['attachment']) ? $_FILES['attachment'] : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $body = isset($_POST['body']) ? trim($_POST['body']) : '';
        $nameError = isset($_POST['name_error']) ? trim($_POST['name_error']) : '';
        $emailError = isset($_POST['email_error']) ? trim($_POST['email_error']) : '';
        $subjectError = isset($_POST['subject_error']) ? trim($_POST['subject_error']) : '';
        $bodyError = isset($_POST['body_error']) ? trim($_POST['body_error']) : '';
        $attachmentError = isset($_POST['attachment_error']) ? $_POST['attachment_error'] : '';

        // Add data to array
        $data = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'body' => $body,
            'attachment' => $attachment,
        ];

        $error = [
            'name_error' => $nameError,
            'email_error' => $emailError,
            'subject_error' => $subjectError,
            'body_error' => $bodyError,
            'attachment_error' => $attachmentError,
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
        if (isset($_FILES['attachment'])) {
            if (empty($data['attachment']['tmp_name'])) {
                $error['attachment_error'] = "Coloque seu curriculo como anexo.";
                $error['error'] = true;
            } else {
                $valid_extensions = ['pdf', 'doc', 'docx'];
                $imgExt = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
                if (!in_array($imgExt, $valid_extensions)) {
                    $valid_extensions = implode(', ', $valid_extensions);
                    $error['attachment_error'] = "Enviei somente {$valid_extensions} ";
                    $error['error'] = true;
                }
            }
        }
        return [$data, $error];
    }
}
