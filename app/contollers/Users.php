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
        if (isLoggedIn()) {
            $users = $this->model->getAll();
            // dump($users);

            View::renderTemplate('user/index.html', [
                'title' => 'Users',
                'users' => $users,
                'logout' => true
            ]);
        } else {
            View::renderTemplate('home/index.html', [
                'title' => 'Home'
            ]);
        }
    }

    public function create()
    {
        View::renderTemplate('user/create.html', [
            'title' => 'Cadastro'
        ]);
    }

    public function store()
    {
        // Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process Form
            $data = $this->model->getPostData();

            // Errors
            $errors = false;

            // Validate Email
            if (empty($data['email'])) {
                $data['email_error'] = "Digite o E-mail";
                $errors = true;
            }
            if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
                $data['email_error'] = "E-mail inválido";
                $errors = true;
            }
            $this->model->customQuery("SELECT `email` FROM users WHERE email = :email", ['email' => $data['email']]);

            if ($this->model->rowCount() > 0) {
                $data['email_error'] = "Já existe um úsuário com esse E-mail";
                $errors = true;
            }

            // Name
            if (empty($data['name'])) {
                $data['name_error'] = "Digite o nome";
                $errors = true;
            }

            // Password
            if (empty($data['password'])) {
                $data['password_error'] = "Digite a senha";
                $errors = true;
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = "Senha precisa no minimo de ser maior que 6 caracteres";
                $errors = true;
            }

            // Password validate
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = "Confirme a senha";
                $errors = true;
            } elseif ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_error'] = "Senhas estão diferentes";
                $errors = true;
            }

            // Make sure error are empty
            if ($errors != true) {
                // Validated

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->model->insert(
                    'users',
                    [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'password' => $data['password'], 'created_at' => date("Y-m-d H:i:s")
                    ]
                )) {
                    $flash = flash('register_success', 'Registrado com sucesso, faça Login');

                    View::renderTemplate('user/login.html', [
                        'title' => 'Login',
                        'data' => $data,
                        'flash' => $flash
                    ]);
                } else {
                    die('Algo deu errado...');
                }
            } else {
                View::renderTemplate('user/create.html', [
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
        //
    }

    public function update($table, $data, $id)
    {
        //
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

            // Check for user/email
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

                    View::renderTemplate('user/login.html', [
                        'title' => 'Login',
                        'data' => $data
                    ]);
                }
            } else {
                // Load view with errors
                View::renderTemplate('user/login.html', [
                    'title' => 'Login',
                    'data' => $data
                ]);
            }
        } else {
            // Load Form
            $data = $this->model->getPostData();
            // Load view
            View::renderTemplate('user/login.html', [
                'title' => 'Login',
                'data' => $data
            ]);
        }
    }

    public function destroy()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();
        View::renderTemplate('user/login.html', [
            'title' => 'Login'
        ]);
    }
}
