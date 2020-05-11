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

    public function index()
    {
        $this->isLogin();

        $users = $this->model->getAll();
        // dump($users);

        View::renderTemplate('users/index.html', [
            'title' => 'Users',
            'users' => $users
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

    public function edit($id)
    {
        $this->isLogin();

        $data = $this->model->customQuery("SELECT * FROM users WHERE id = :id", ['id' => $id]);

        if ($data) {
            View::renderTemplate('users/edit.html', [
                'data' => $data
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
            // Errors
            $errors = false;

            // Process Form
            $data = $this->model->getPostData();

            // Make sure error are empty
            if ($errors != true && $data['errors'] != true) {
                $this->model->updateQuery('users', ['name' => $data['name'], 'last_name' => $data['last_name'], 'bio' => $data['bio'], 'updated_at' => date("Y-m-d H:i:s")], ['id', $data['id']]);

                // Update user
                if ($this->model->rowCount()) {
                    $flash = flash('register_success', 'Atualizado com sucesso!');

                    View::renderTemplate('users/edit.html', [
                        'title' => 'Edit',
                        'data' => $data,
                        'flash' => $flash
                    ]);
                } else {
                    die('Algo deu errado...');
                }
            } else {
                View::renderTemplate('users/edit.html', [
                    'title' => 'Edit',
                    'data' => $data
                ]);
            }
        }
    }

    public function login()
    {
        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Process
            $data = $this->model->getPostData();

            // Errors
            $errors = false;

            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = "Digite o E-mail";
                $errors = true;
            } elseif (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                $data['email_error'] = "E-mail inválido";
            }

            // Password
            if (empty($data['password'])) {
                $data['password_error'] = "Digite a senha";
                $errors = true;
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = "Senha precisa no minimo de ser maior que 6 caracteres";
                $errors = true;
            }

            $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data['email']]);

            // Check for users/email
            if ($this->model->rowCount() < 0) {
                // User not Found
                $data['email_error'] = "Nenhum úsuário encontrado";
                $errors = true;
            }

            // Make sure error are empty
            if ($errors != true) {
                // Validate
                // Check an set logged in user
                $loggedInUser = $this->model->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    // Create session
                    $this->model->createUserSession($loggedInUser);
                } else {
                    $data['password_error'] = "Email ou Senha incorretos";

                    View::renderTemplate('users/login.html', [
                        'title' => 'Login',
                        'data' => $data
                    ]);
                }
            } else {
                // Load view with errors
                View::renderTemplate('users/login.html', [
                    'title' => 'Login',
                    'data' => $data
                ]);
            }
        } else {
            View::renderTemplate('users/login.html');
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
