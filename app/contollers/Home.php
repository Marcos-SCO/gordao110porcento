<?php

declare(strict_types=1);

namespace App\Controllers;

use \Core\View;

class Home extends \App\Models\Home
{
    public function index()
    {
        $users = $this->getAll();
        // dump($users);

        View::renderTemplate('home/index.html', [
            'title' => 'Home',
            'users' => $users
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
