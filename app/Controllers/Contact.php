<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Facade\Email;

class Contact extends Controller
{
    public $model;
    public $emailFacade;
    public $dataPage = 'contact';

    public function __construct()
    {
        $this->model = $this->model('Contact');

        $this->emailFacade = new Email;
    }

    function processFileAttachmentData($attachment)
    {
        $fileAttachmentName = verifyValue($attachment, 'tmp_name');

        if (!$fileAttachmentName) {
            $error['attachment_error'] = "Coloque seu currículo como anexo.";

            $error['error'] = true;

            return $error;
        }

        $validExtensions = ['pdf', 'doc', 'docx'];
        $validExtensionsString = implode(', ', $validExtensions);

        $fileExt = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));

        $isImgExtensionIsValid = in_array($fileExt, $validExtensions);

        if (!$isImgExtensionIsValid) {
            $error['attachment_error'] = "Enviei somente {$validExtensionsString} ";

            $error['error'] = true;

            return $error;
        }

        return [];
    }

    public function getRequestData()
    {
        // Sanitize data
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$post) return;

        $name = indexParamExistsOrDefault($post, 'name');

        $subject = indexParamExistsOrDefault($post, 'subject');

        $attachment = indexParamExistsOrDefault($_FILES, 'attachment');

        $email = indexParamExistsOrDefault($post, 'email');

        $isValidEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        $body = indexParamExistsOrDefault($post, 'body');

        // Add data to array
        $data = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'body' => $body,
            'attachment' => $attachment,
        ];

        $error = ['error' => false];

        if (empty($data['name'])) {
            $error['name_error'] = "Informe seu nome.";
            $error['error'] = true;
        }

        if (!$isValidEmail) {
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
            $error['body_error'] = "Preencha o campo de mensagem.";
            $error['error'] = true;
        }

        if ($attachment) $error = array_merge($error, $this->processFileAttachmentData($attachment));

        return ['data' => $data, 'errorData' => $error];
    }

    public function index($requestData = null)
    {
        $contactPage = indexParamExistsOrDefault($requestData, 'contact');

        $permittedContactPages = ['message', 'work'];

        $isAValidContactPage =
            in_array($contactPage, $permittedContactPages);

        if (!$isAValidContactPage) return redirect('home');

        return $this->message(['contactPage' => $contactPage]);
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

        $contactPage = indexParamExistsOrDefault($data, 'contactPage');

        $contaPageTitle = $contactPage == 'work' ? 'Envie sua mensagem com um anexo' : 'Contato - envie sua mensagem';

        return View::render('contact/message.php', [
            'dataPage' => $this->dataPage . '/' . $contactPage,
            'title' => $contaPageTitle,
            'data' => $data,
            'error' => $error,
            'flash' => $flash
        ]);
    }

    public function sendMessage($requestData = [])
    {
        $contactPage = indexParamExistsOrDefault($requestData, 'contact');

        $submittedPostData =
            isset($_SESSION['submitted']) &&
            $_SERVER['REQUEST_METHOD'] == 'POST';

        if ($submittedPostData) {
            return redirect('contact/' . $contactPage);
        }

        $postResultData = $this->getRequestData($contactPage);

        $data = indexParamExistsOrDefault($postResultData, 'data');

        $errorData =
            indexParamExistsOrDefault($postResultData, 'errorData');

        $isErrorResult = $errorData['error'] == true;

        $data['contactPage'] = $contactPage;

        $_SESSION['submitted'] = true;

        $emailAttachMent = verifyValue($_FILES, 'attachment');

        if ($emailAttachMent) $data['attachment'] = $emailAttachMent;

        if ($isErrorResult) {
            return $this->message($data, $errorData);
        }

        $emailSent = $this->emailFacade->sendEmailHandler($data, $emailAttachMent);

        $emailError = indexParamExistsOrDefault($emailSent, 'error');

        if ($emailError) return $this->message($data, ['body_error' => 'Infelizmente o e-mail não podê ser enviado, tente novamente mais tarde']);

        flash('post_message', 'Mensagem Enviada com sucesso');

        return redirect('contact/success');
    }
}
