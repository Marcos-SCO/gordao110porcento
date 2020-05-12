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

    public function index($flash = null)
    {
        $this->isLogin();

        $users = $this->model->getAll();

        View::renderTemplate('users/index.html', [
            'title' => 'Users',
            'users' => $users,
            'flash' => $flash
        ]);
    }

    public function create()
    {
        if (!isLoggedIn()) {
            View::renderTemplate('users/login.html');
            return exit();
        }
        View::renderTemplate('users/create.html', [
            'title' => 'Cadastro'
        ]);
    }

    public function store()
    {
        $this->isLogin();

        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Errors
            $errors = false;

            // Process Form
            $data = $this->model->getPostData();

            $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data['email']]);

            if ($this->model->rowCount() > 0) {
                $data['email_error'] = "Já existe um úsuário com esse E-mail";
                $errors = true;
            }

            // Make sure error are empty
            if ($errors != true && $data['errors'] != true) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->model->insertQuery(
                    'users',
                    [
                        'name' => $data['name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'password' => $data['password'], 'created_at' => date("Y-m-d H:i:s")
                    ]
                )) {
                    $flash = flash('register_success', 'Registrado com sucesso, faça Login');

                    View::renderTemplate('users/login.html', [
                        'title' => 'Login',
                        'data' => $data,
                        'flash' => $flash
                    ]);
                } else {
                    die('Algo deu errado...');
                }
            } else {
                View::renderTemplate('users/create.html', [
                    'title' => 'Login',
                    'data' => $data
                ]);
            }
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id, $error = null, $flash = null)
    {
        $this->isLogin();

        $data = $this->model->customQuery("SELECT * FROM users WHERE id = :id", ['id' => $id]);

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
            $data[0] = $data;
            $data[1] = $data;
            $error = $data[1][1];
            $id = $data[0][0]['id'];
            // Make sure error are empty
            if ($error['error'] != true) {
                $img = $data[0][0]['img'];
                $postImg = $data[0][0]['post_img'];
                if ($img !== "") {
                    $fullPath = $this->imgFullPath('users', $id, $img);
                    $this->moveUpload($fullPath);
                    $data['img'] = explode('/', $fullPath);
                } else {
                    $data[0][0]['img'] = $postImg;
                }

                $this->model->updateUser($data[0][0]);
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

    public function login()
    {
        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process
            $data = $this->model->getPostData();
            $data[0] = $data;
            $data[1] = $data;
            $error = $data[1][1];
            $id = $data[0][0]['id'];

            $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data[0][0]['email']]);
            // Check for users/email
            if ($this->model->rowCount() < 0) {
                // User not Found
                $error['email_error'] = "Nenhum úsuário encontrado";
                $error['error'] = true;
            }

            // Make sure error are empty
            if ($error['error'] != true) {
                // Validate
                // Check an set logged in user
                $loggedInUser = $this->model->login($data[0][0]['email'], $data[0][0]['password']);
                if ($loggedInUser) {
                    // Create session
                    $this->model->createUserSession($loggedInUser);
                    $flash = flash('register_success', 'Logado com sucesso!');
                    return $this->index($flash);
                } else {
                    return View::renderTemplate('users/login.html', [
                        'data' => $data[0][0],
                        'error' => $error
                    ]);
                }
            } else {
                // Load view with errors
                return View::renderTemplate('users/login.html', [
                    'data' => $data[0][0],
                    'error' => $error
                ]);
            }
        } else {
            return View::renderTemplate('users/login.html');
        }
    }

    public function destroy()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();

        redirect('users/login');
    }
}
