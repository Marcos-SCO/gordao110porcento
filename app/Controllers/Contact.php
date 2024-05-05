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

    public function index($paramsArray = null)
    {
        $contactType = !empty($paramsArray['contact']) && isset($paramsArray['contact']) ?  $paramsArray['contact'] : '';

        if ($contactType == 'message') return $this->message();
        if ($contactType == 'work') return $this->work();

        if ($contactType == '') return redirect('home');
    }

    public function success()
    {
        View::render('contact/success.php', [
            'title' => 'Sua menssagem foi enviada com sucesso!',
        ]);
    }

    public function message($data = null, $error = null, $flash = null)
    {
        if (isset($_SESSION['submitted'])) unset($_SESSION['submitted']);

        View::render('contact/message.php', [
            'title' => 'Contato - envie sua menssagem',
            'data' => $data,
            'error' => $error,
            'flash' => $flash
        ]);
    }

    public function work($data = null, $error = null, $flash = null)
    {
        if (isset($_SESSION['submitted'])) unset($_SESSION['submitted']);

        View::render('contact/work.php', [
            'title' => 'Envie sua mensagem com um anexo',
            'data' => $data,
            'error' => $error,
            'flash' => $flash
        ]);
    }

    public function messageSend()
    {

        $submittedPostData =
            isset($_SESSION['submitted']) &&
            $_SERVER['REQUEST_METHOD'] == 'POST';

        if ($submittedPostData) {
            return redirect('contact/message');
        }

        $result = $this->getPostData();
        $data = $result[0];
        $error = $result[1];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) return $this->message($data, $error);

        $_SESSION['submitted'] = true;
        $this->sendEmailHandler($data);

        return redirect('contact/success');
    }

    public function workSend()
    {
        $submittedPostData =
            isset($_SESSION['submitted']) &&
            $_SERVER['REQUEST_METHOD'] == 'POST';

        if ($submittedPostData) {
            redirect('contact/work');
        }

        $result = $this->getPostData();
        $data = $result[0];
        $error = $result[1];

        $isErrorResult = $error['error'] == true;

        if ($isErrorResult) {
            $data['attachment'] = $_FILES["attachment"]['tmp_name'];

            return $this->work($data, $error);
        }

        $flash = flash('post_message', 'Menssagem Enviada com sucesso');
        $this->sendEmailHandler($data, $data['attachment']);

        return redirect('contact/success');
    }

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';

        $subject =
            isset($_POST['subject']) ? trim($_POST['subject']) : '';

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

            $fileAttachTmpNameEmpty =
                empty($data['attachment']['tmp_name']);

            if ($fileAttachTmpNameEmpty) {
                $error['attachment_error'] = "Coloque seu currículo como anexo.";

                $error['error'] = true;
            }

            if (!$fileAttachTmpNameEmpty) {

                $validExtensions = ['pdf', 'doc', 'docx'];
                $validExtensionsString = implode(', ', $validExtensions);

                $imgExt = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));

                $isImgExtensionIsValid =
                    in_array($imgExt, $validExtensions);

                if (!$isImgExtensionIsValid) {
                    $error['attachment_error'] = "Enviei somente {$validExtensionsString} ";

                    $error['error'] = true;
                }
            }
        }

        return [$data, $error];
    }
}
