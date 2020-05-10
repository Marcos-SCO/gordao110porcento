<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Config\Config;

class Posts extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Post');
    }

    public function index()
    {
        // $users = $this->model->getAll();
        // dump($users);

        View::renderTemplate('posts/index.html', [
            'title' => 'Posts - Açougue a 110%'
        ]);
    }

    public function create()
    {
        View::renderTemplate('posts/create.html', [
            'title' => 'Criar Post - Açougue a 110%'
        ]);
    }


    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->model->getPostData();

            // Validate data
            $errors = false;
            if (empty($data['title'])) {
                $data['title_error'] = "Coloque o título.";
                $errors = true;
            }
            if (empty($data['body'])) {
                $data['body_error'] = "Preencha o campo de texto.";
                $errors = true;
            }
            if (empty($data['img_path'])) {
                $data['img_path_error'] = "Insira uma imagem";
                $errors = true;
            }

            $imgFullPath = $this->model->imgHandler('posts');

            if ($data["img_path"]["tmp_name"] != "") {

                $valid_extensions = ['jpeg', 'jpg', 'png', 'gif', 'pdf'];

                $imgExt = strtolower(pathinfo($_FILES['img_path']['name'], PATHINFO_EXTENSION));

                if (in_array($imgExt, $valid_extensions)) {
                    move_uploaded_file($_FILES['img_path']['tmp_name'], $imgFullPath);
                } else {
                    $data['img_path_error'] = "Envie somente Imagens";
                    $errors = true;
                }
            } else {
                $data['img_path_error'] = "Envie uma imagem";
                $errors = true;
            }

            if ($errors != true) {
                if ($this->model->addPost($data)) {
                    flash('post_message', 'Post adicionado');
                    
                    dump('Envio deu bom');
                } else {
                    die('Algo deu errado..');
                }
            } else {
                View::renderTemplate('posts/create.html', [
                    'title' => 'Criar Post - Açougue a 110%',
                    'data' => $data,
                    'imgFullPath' => $imgFullPath
                ]);
            }
        }
    }

    public function show()
    {
        // dump("achou {$url[0]}");
        View::renderTemplate('posts/show.html', [
            'title' => 'Show Post - Açougue a 110%'
        ]);
    }

    public function edit($id)
    {
        View::renderTemplate('posts/edit.html', [
            'title' => "Edit Post {$id}"
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->model->getPostData();
            $this->model->updatePost($data);
        }
    }

    public function destroy($id)
    {
        //
    }
}
