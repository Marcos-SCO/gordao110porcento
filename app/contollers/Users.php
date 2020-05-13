<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

class Users extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('User');
    }

    public function index($id = 1, $flash = null)
    {
        $this->isLogin();

        $results = $this->pagination('users', $id, $limit = 10, $option = 'AND `status` DESC');

        View::renderTemplate('users/index.html', [
            'title' => 'Users',
            'users' => $results[4],
            'flash' => $flash,
            'pageId'=> $id,
            'prev' => $results[0],
            'next' => $results[1],
            'totalResults' => $results[2],
            'totalPages' => $results[3],
        ]);
    }

    public function create($data = false, $error = false)
    {
        $this->isLogin();

        View::renderTemplate('users/create.html', [
            'title' => 'Cadastro',
            'data' => $data,
            'error' => $error
        ]);
    }

    public function store()
    {
        $this->isLogin();

        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process Form
            $data = $this->model->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];

            $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data[0]['email']]);

            if ($this->model->rowCount() > 0) {
                $error['email_error'] = "Já existe um úsuário com esse E-mail";
                $error['error'] = true;
            }

            // Make sure error are empty
            if ($error['error'] != true) {
                // Hash password
                $data[0]['password'] = password_hash($data[0]['password'], PASSWORD_DEFAULT);
                // Register user
                if ($this->model->insertUser($data[0])) {
                    $flash = flash('register_success', 'Usuário registrado com sucesso!');
                    return $this->index($flash);
                } else {
                    die('Algo deu errado...');
                }
            } else {
                return $this->create($data[0], $error);
            }
        }
    }

    public function status($id, $status)
    {
        if ((isset($_SESSION['adm_id']) && $_SESSION['adm_id'] != 1) || !(isset($_SESSION['user_id'])) && $id == 1) {
            return redirect('home');
        } else {
            $this->model->updateStatus($id, $status);
            ($status == 1) ? $message = 'Usuário ativado com sucesso' : $message = 'Usuário desativado com sucesso!';
            $flash = flash('register_success', $message);
            return $this->index($id = 1, $flash);
        }
    }

    public function show($id)
    {
        $user = $this->model->getAllFrom('users', $id);
        // $posts = $this->model->getAllFrom('posts', $data->id, 'user_id');
        $posts = $this->model->selectQuery('posts', "WHERE user_id = $user->id ORDER BY created_at DESC");

        View::renderTemplate('users/show.html', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function edit($id, $error = null, $flash = null)
    {
        $this->isLogin();

        $data = $this->model->getAllFrom('users', $id);

        if ($data) {
            View::renderTemplate('users/edit.html', [
                'data' => $data,
                'flash' => $flash,
                'error' => $error
            ]);
        } else {
            dump('Usuário não existe');
        }
    }

    public function update()
    {
        $this->isLogin();

        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process Form
            $data = $this->model->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];
            // Make sure error are empty
            if ($error['error'] != true) {
                $img = $data[0]['img'];
                $postImg = $data[0]['post_img'];
                if ($img !== "") {
                    $fullPath = $this->imgFullPath('users', $id, $img);
                    $this->moveUpload($fullPath);
                    $data['img'] = explode('/', $fullPath);
                } else {
                    $data[0]['img'] = $postImg;
                }

                $this->model->updateUser($data[0]);
                // Update user
                if ($this->model->rowCount()) {
                    $flash = flash('register_success', 'Atualizado com sucesso!');
                    return $this->edit($id, $error = null, $flash);
                } else {
                    die('Algo deu errado...');
                }
            } else {
                return $this->edit($id, $error);
            }
        }
    }

    public function login($flash = null)
    {
        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            // Process
            $data = $this->model->getPostData();
            $error = $data[1];
            $id = $data[0]['id'];

            // Dont let users with status 0 login
            $this->model->blockLogin($data[0]['email']);

            $this->model->customQuery("SELECT `email` FROM users WHERE `email` = :email", ['email' => $data[0]['email']]);

            // Check for users/email
            if ($this->model->rowCount() <= 0) {
                // User not Found
                $error['email_error'] = "Nenhum usuário encontrado";
                $error['error'] = true;
            }

            // Make sure error are empty
            if ($error['error'] != true) {
                // Validate
                // Check an set logged in user
                $loggedInUser = $this->model->login($data[0]['email'], $data[0]['password']);
                if ($loggedInUser) {
                    // Create session
                    $this->model->createUserSession($loggedInUser);
                    $flash = flash('register_success', 'Logado com sucesso!');
                    return $this->index($flash);
                } else {
                    $error['password_error'] = "Email ou senha incorretos";
                    return View::renderTemplate('users/login.html', [
                        'data' => $data[0],
                        'error' => $error
                    ]);
                }
            } else {
                // Load view with errors
                return View::renderTemplate('users/login.html', [
                    'data' => $data[0],
                    'error' => $error
                ]);
            }
        } else {
            return View::renderTemplate('users/login.html', ['flash' => $flash]);
        }
    }

    public function destroy()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['adm_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();

        redirect('users/login');
    }
}
