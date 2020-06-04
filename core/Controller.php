<?php

namespace Core;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

// Base controller | Loads the models 
class Controller
{
    // Load Model
    public function model($model)
    {
        $intance = "App\Models\\" . $model;

        // Instantiate model
        return new $intance;
    }

    // Verifies if a user is login, if not redirect
    public function isLogin()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            return exit();
        }
    }

    /* Dinamic page links start */
    public static function createMore($BASE, $table, $text = 'Quer adicionar mais?')
    {
        if ($_SESSION['user_status'] == 1) {
            echo "<a class='createBtn btn' href='$BASE/$table/create' style='width:100%;max-width:300px;display:block;margin:1rem auto;'>$text</a>";
        }
    }

    public static function editDelete($BASE, $table, $data, $text = 'Quer Mesmo deletar?')
    {
        if (($data->user_id == $_SESSION['user_id']) or ($_SESSION['adm_id'] == 1)) {
            $verb = ($table == 'categories') ? 'destroy' : 'delete';
            $idCategory = '';
            if ($table == 'products') {
                $idCategory = '/' . $data->id_category;
            } else if ($table == 'categories') {
                $idCategory = '/' . $data->id;
            }
?>
            <div class="editDelete d-flex p-1 flex-wrap">
                <a href="<?= "{$BASE}/{$table}/edit/{$data->id}" ?>" class="btn btn-warning m-1" style="height:38px">Editar</a>
                <form action="<?= "{$BASE}/{$table}/$verb/{$data->id}{$idCategory}" ?>" method="post">
                    <button onclick="return confirm('<?= $text ?>')" class="btn btn-danger m-1">Deletar</button>
                </form>
            </div>
<?php }
    }
    /* Dinamic page links end */

    // Delete functoin for controllers
    public function delete($id)
    {
        $url = explode('/', $_SERVER['QUERY_STRING']);
        // Get table with url
        $table = $url[0];
        $idCategory = $url[3] ?? null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->model->deleteQuery($table, ['id' => $id]);
            if ($this->model->rowCount() > 0) {
                $this->deleteFolder($table, $id, $idCategory);
                $flash = flash('register_seccess', 'Deletado com sucesso');
                return $this->index(1, $flash);
            } else {
                $flash = flash('register_seccess', 'Ocorreu um erro');
                redirect($table);
            }
        } else {
            redirect($table);
        }
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
        if ($_FILES["img"]["tmp_name"] != "") {
            move_uploaded_file($_FILES['img']['tmp_name'], $imgFullPath);
        } else {
            $data['img_error'] = "Envie uma imagem";
            $error = true;
        }
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

    public function imgFullPath($table, $id, $imgName, $category_id = null)
    {
        if ($category_id != null) {
            $this->deleteFolder($table, $id, $category_id);
            // Create folder
            if (!file_exists("../public/img/{$table}/category_{$category_id}/id_$id")) {
                mkdir("../public/img/{$table}/category_{$category_id}/id_$id", 0755, true);
            }
            $upload_dir = "img/{$table}/category_$category_id/id_$id/";
        } else {
            // delete the folder
            $this->deleteFolder($table, $id);
            if (!file_exists("../public/img/{$table}/id_$id")) {
                mkdir("../public/img/{$table}/id_$id");
            }
            $upload_dir = "img/{$table}/id_$id/";
        }
        $picProfile = $imgName;

        $imgFullPath = $upload_dir . $picProfile;

        return $imgFullPath;
    }

    public function deleteFolder($table, $id, $idCategory = null, $massDel = null)
    {
        // Delete all imgs with id category and products
        if ($idCategory != null && $massDel != null) {
            if (file_exists("../public/img/{$table}/category_{$idCategory}")) {
                $dir = "../public/img/{$table}/category_{$idCategory}";
                function rrmdir($dir)
                {
                    foreach (glob($dir . '/*') as $file) {
                        (is_dir($file)) ? rrmdir($file) : unlink($file);
                    }
                    rmdir($dir);
                }
                rrmdir($dir);
            }
        } else if ($idCategory != null) {
            // Delete imgs products
            if (file_exists("../public/img/{$table}/category_{$idCategory}/id_{$id}")) {
                array_map('unlink', glob("../public/img/{$table}/category_{$idCategory}/id_{$id}/*.*"));
                rmdir("../public/img/{$table}/category_{$idCategory}/id_{$id}");
            }
        } else {
            // Delete imgs with id named folder
            if (file_exists("../public/img/{$table}/id_$id")) {
                array_map('unlink', glob("../public/img/{$table}/id_{$id}/*.*"));
                rmdir("../public/img/{$table}/id_$id");
            }
        }
    }



    /* Img methods End  */

    /* Pagination start */
    public function pagination($table, $id = 1, $limit = 5, $optionID = '', $orderOption = '')
    {
        /* Set current, prev and next page */
        $prev = ($id) - 1;
        $next = ($id) + 1;
        /* Calculate the offset */
        $offset = (($id * $limit) - $limit);

        /* Query the db for total results.*/
        if ($optionID != '') {
            list($idKey, $idVal) = $optionID;
            $key = strval($idKey);
            $val = strval($idVal);
            $optionID = " WHERE {$key} = {$val}";
        }
        $totalResults = $this->model->customQuery("SELECT COUNT(*) AS total FROM {$table} $optionID");

        $totalPages = ceil($totalResults->total / $limit);

        $orderBy = "$optionID ORDER BY id {$orderOption} LIMIT $limit OFFSET $offset";
        $resultTable = $this->model->selectQuery($table, $orderBy);

        return [$prev, $next, $totalResults, $totalPages, $resultTable];
    }
    /* pagination end */

    // Email start
    public function sendEmailHandler($data, $attachment = null)
    {
        $name = strip_tags($data['name']);
        $email = strip_tags($data['email']);
        $subject = strip_tags($data['subject']);
        $bodyStriped = strip_tags($data['body']);
        $body = "<b>{$name}</b> com email <b>{$email}</b><p>Enviou:</p><p>{$bodyStriped}</p>";
        $this->Mailer($email, 'marcos_sco@outlook.com', $name, $subject, $body, 1, $attachment);
        $this->Mailer('marcosXsco@gmail.com', $email, $name, "{$name} sua mensagem foi enviada", "<br>Olá {$name}, Obrigado por enviar sua menssagem.<p><b>Você enviou:</b><br>{$bodyStriped}</p>", null, $attachment);
    }

    public function Mailer($sentFrom, $email, $name, $subject, $body, $cc = null, $attachment = null)
    {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->Charset = 'UTF-8';
            //$mail->SMTPDebug = 1;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            //$mail->Host       = 'smtp1.example.com';// Set the SMTP server to send through
            // $mail->Host       = 'smtplw.com.br'; // Set the SMTP server to send through
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            // $mail->Username   = 'user@example.com';                     // SMTP username
            $mail->Username   = 'marcosXsco@gmail.com'; // SMTP username
            $mail->Password   = '****************'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            //sender
            $mail->setFrom(utf8_decode($sentFrom), utf8_decode($subject));
            // reciver
            $mail->addAddress(utf8_decode($email), utf8_decode($name));     // Add a recipient
            // $mail->addAddress('marcosXsco@gmail.com');               // Name is optional
            $mail->addReplyTo(utf8_decode($sentFrom), "Responder {$sentFrom}");
            if ($cc != null) {
                $mail->addCC('marcosXsco@gmail.com');
            }
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            if ($attachment != null) {
                // $mail->addAttachment('/var/tmp/file.tar.gz');// Add attachments
                $mail->addAttachment($attachment['tmp_name'], utf8_decode($attachment['name']), 'base64', $attachment['type']);
            }
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = utf8_decode($subject);
            $mail->Body    = utf8_decode($body);
            $striped = strip_tags(utf8_decode($body));
            $mail->AltBody = "{$striped}";

            $mail->send();
            // echo 'Message has been sent';
        } catch (\Exception $e) {
            throw new \Exception("Message could not be sent. Mailer Error: $mail->ErrorInfo");
        }
    }
}
