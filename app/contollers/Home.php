<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\View;

class Home extends Controller
{
    // The create method should return a view with a form.

    // The store method should handle the form and create the entity and redirect.

    // The edit method should return a view with a form with data from the entity.

    // The update method should handle the form and update the entity and redirect.
    
    public function __construct()
    {
        $this->model = $this->model('User');
    }

    public function index()
    {
        // $users = $this->model->getAll();
        // dump($users);

        View::renderTemplate('home/index.html', [
            'title' => 'Açougue a 110%'
        ]);
    }

    public function create()
    {
        //
    }


    public function store($request)
    {
        //
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

    public function destroy($id)
    {
        //
    }
}
