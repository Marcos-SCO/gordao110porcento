<?php

namespace Core;

use App\Config\Config;

// Base controller | Loads the models 
class Controller
{
    // Load Model
    public function model($model)
    {
        $instance = "App\Models\\" . $model;

        // Instantiate model
        return new $instance;
    }

    // Verifies if a user is login, if not redirect
    public function isLogin()
    {
        if (isLoggedIn()) return;

        redirect('login');
        return exit();
    }

    // Delete functoin for controllers
    public function delete($id)
    {
        $url = explode('/', $_SERVER['QUERY_STRING']);
        // Get table with url
        $table = $url[0];
        $idCategory = $url[3] ?? null;

        $isPostMethod = $_SERVER['REQUEST_METHOD'] == 'POST';

        if (!$isPostMethod) redirect($table);

        $this->model->deleteQuery($table, ['id' => $id]);

        $itemWasDeleted = $this->model->rowCount() > 0;

        if (!$itemWasDeleted) {
            $flash = flash('register_success', 'Ocorreu um erro');
            redirect($table);
        }

        $this->deleteFolder($table, $id, $idCategory);
        $flash = flash('register_success', 'Deletado com sucesso');

        return $this->index(1, $flash);
    }

    /* Pagination start */
    public function pagination($table, $id = 1, $limit = 5, $optionId = '', $orderOption = '')
    {
        /* Set current, prev and next page */
        $prev = ($id) - 1;
        $next = ($id) + 1;

        /* Calculate the offset */
        $offset = (($id * $limit) - $limit);

        /* Query the db for total results.*/
        if ($optionId != '') {
            list($idKey, $idVal) = $optionId;

            $key = strval($idKey);
            $val = strval($idVal);
            $optionId = " WHERE {$key} = {$val}";
        }

        $totalResults = $this->model->customQuery("SELECT COUNT(*) AS total FROM {$table} $optionId");

        $totalPages = ceil($totalResults->total / $limit);

        $orderOption = ($orderOption != '') ? $orderOption : '';

        $orderBy = "$optionId $orderOption LIMIT $limit OFFSET $offset";
        $resultTable = $this->model->selectQuery($table, $orderBy);

        return [$prev, $next, $totalResults, $totalPages, $resultTable];
    }
    /* pagination end */
}
