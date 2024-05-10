<?php

namespace Core;

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
            $flash = flash('register_seccess', 'Ocorreu um erro');
            redirect($table);
        }

        $this->deleteFolder($table, $id, $idCategory);
        $flash = flash('register_seccess', 'Deletado com sucesso');

        return $this->index(1, $flash);
    }

    /* Img methods Start */

    public function imgValidate()
    {
        $valid_extensions = ['jpeg', 'jpg', 'png', 'gif'];
        $imgExt = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

        $error = [0 => false, 1 => false];

        if (!in_array($imgExt, $valid_extensions)) {
            $valid_extensions = implode(', ', $valid_extensions);
            $error = [0 => true, 1 =>  "Enviei somente {$valid_extensions} "];
        }

        return $error;
    }

    public function moveUpload($imgFullPath)
    {

        $isEmptyImg = $_FILES["img"]["tmp_name"] == "";

        if ($isEmptyImg) {
            $data['img_error'] = "Envie uma imagem";
            $error = true;

            return $error;
        }

        move_uploaded_file($_FILES['img']['tmp_name'], $imgFullPath);
    }

    public function imgCreateHandler($table, $folderName = null)
    {
        $tableId = $this->model->customQuery("SELECT AUTO_INCREMENT
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = :schema
        AND TABLE_NAME = :table", [
            'schema' => 'db_corte_110porcento',
            'table' => $table
        ]);

        $tableId = strval($tableId->AUTO_INCREMENT);

        return $this->imgFullPath($table, $tableId, $_FILES['img']['name'], $folderName);
    }

    public function imgFullPath($table, $id, $imgName, $categoryId = null)
    {

        $emptyCategoryId = $categoryId == null;

        if ($emptyCategoryId) {

            // delete the folder
            $this->deleteFolder($table, $id);
            if (!file_exists("../public/resources/img/{$table}/id_$id")) {
                mkdir("../public/resources/img/{$table}/id_$id");
            }
            $upload_dir = "img/{$table}/id_$id/";
        }

        if (!$emptyCategoryId) {
            $this->deleteFolder($table, $id, $categoryId);
            // Create folder

            if (!file_exists("../public/resources/img/{$table}/category_{$categoryId}/id_$id")) {

                mkdir("../public/resources/img/{$table}/category_{$categoryId}/id_$id", 0755, true);
            }

            $upload_dir = "img/{$table}/category_$categoryId/id_$id/";
        }

        $picProfile = $imgName;

        $imgFullPath = $upload_dir . $picProfile;

        return $imgFullPath;
    }

    public function deleteFolder($table, $id, $idCategory = null, $massDel = null)
    {
        $notEmptyCategoryAndMassDelete = $idCategory != null && $massDel != null;

        if (!$notEmptyCategoryAndMassDelete) {
            // Delete imgs with id named folder
            if (file_exists("../public/resources/img/{$table}/id_$id")) {
                array_map('unlink', glob("../public/resources/img/{$table}/id_{$id}/*.*"));
                rmdir("../public/resources/img/{$table}/id_$id");
            }

            return;
        }

        // Delete all imgs with id category and products
        if ($notEmptyCategoryAndMassDelete) {

            if (file_exists("../public/resources/img/{$table}/category_{$idCategory}")) {
                $dir = "../public/resources/img/{$table}/category_{$idCategory}";
                function rrmdir($dir)
                {
                    foreach (glob($dir . '/*') as $file) {
                        (is_dir($file)) ? rrmdir($file) : unlink($file);
                    }
                    rmdir($dir);
                }

                rrmdir($dir);
            }
        }

        if ($idCategory != null) {
            // Delete imgs products
            if (file_exists("../public/resources/img/{$table}/category_{$idCategory}/id_{$id}")) {
                array_map('unlink', glob("../public/resources/img/{$table}/category_{$idCategory}/id_{$id}/*.*"));
                rmdir("../public/resources/img/{$table}/category_{$idCategory}/id_{$id}");
            }
        }
    }



    /* Img methods End  */

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
