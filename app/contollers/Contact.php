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
        } else if($type == 'work') {
            return $this->work();
        } else {
            return redirect('home');
        }
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
            'title' => 'Envio sua mensagem com um pdf',
            'data' => $data,
            'error' => $error,
            'flash' => $flash
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['submitted'])) {
            $result = $this->model->getPostData();
            $data = $result[0];
            $error = $result[1];
            // Validate data
            if ($error['error'] != true) {
                $_SESSION['submitted'] = true;
                $flash = flash('post_message', 'Menssagem Enviada com sucesso');

                $name = strip_tags($data['name']);
                $email = strip_tags($data['email']);
                $subject = strip_tags($data['subject']);
                $bodyStriped = strip_tags($data['body']);
                $body = "<b>{$name}</b> com email <b>{$email}</b><p>Enviou:</p><p>{$bodyStriped}</p>";
                $this->Mailer($email, 'marcos_sco@outlook.com', $name, $subject, $body, 1);
                $this->Mailer('marcosXsco@gmail.com', $email, $name, "{$name} sua mensagem foi enviada", "<br>Olá {$name}, Obrigado por enviar sua menssagem.<p><b>Você enviou:</b><br>{$bodyStriped}</p>");
                View::renderTemplate('home/index.html', ['flash' => $flash]);
            } else {
                return $this->message($data, $error);
            }
        }
    }

    public function show($id, array $flash = null)
    {
        $data = $this->model->getAllFrom('posts', $id);
        $user = $this->model->getAllFrom('users', $data->user_id);
        return View::renderTemplate('posts/show.html', [
            'title' => $data->title,
            'data' => $data,
            'user' => $user,
            'flash' => $flash
        ]);
    }

    public function edit($id, $error = false)
    {
        $this->isLogin();
        $data = $this->model->getAllFrom('posts', $id);

        View::renderTemplate('posts/edit.html', [
            'title' => "Editar - $data->title",
            'data' => $data,
            'error' => $error
        ]);
    }

    public function update()
    {
        $this->isLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->model->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];

            if ($error['error'] != true) {
                $img = $data[0]['img'];
                $postImg = $data[0]['post_img'];
                if ($img !== "") {
                    $fullPath = $this->imgFullPath('posts', $id, $img);
                    $this->moveUpload($fullPath);
                    $data['img'] = explode('/', $fullPath);
                } else {
                    $data[0]['img'] = $postImg;
                }

                $this->model->updatePost($data[0]);
                $flash = flash('post_message', 'Post Atualizado');

                return $this->show($id, $flash);
            } else {
                return $this->edit($id, $error);
            }
        }
    }

    public function delete($id)
    {
        $this->model->deletePost('posts', ['id' => $id]);
        if ($this->model->rowCount() > 0) {
            $this->deleteFolder('posts', $id);
            $flash = flash('register_seccess', 'Deletado com sucesso');
            return $this->index(1, $flash);
        }
    }
}
