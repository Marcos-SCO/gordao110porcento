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

    public function isLogin()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            return exit();
        }
    }

    public function moveUpload($imgFullPath)
    {
        if ($_FILES["img"]["tmp_name"] != "") {

            $valid_extensions = ['jpeg', 'jpg', 'png', 'gif', 'pdf'];

            $imgExt = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));

            if (in_array($imgExt, $valid_extensions)) {
                move_uploaded_file($_FILES['img']['tmp_name'], $imgFullPath);
            } else {
                $data['img_error'] = "Envie somente Imagens";
                $errors = true;
            }
        } else {
            $data['img_error'] = "Envie uma imagem";
            $errors = true;
        }
    }

    public function imgCreateHandler($table)
    {
        $tableId = $this->model->customQuery("SELECT AUTO_INCREMENT
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = :schema
        AND TABLE_NAME = :table", [
            'schema' => 'db_corte_110porcento',
            'table' => $table
        ]);
        $tableId = strval($tableId->AUTO_INCREMENT);
        return $this->imgFullPath($table, $tableId, $_FILES['img']['name']);
    }

    public function deleteFolder($table, $id)
    {
        if (file_exists("../public/img/{$table}/id_$id")) {
            array_map('unlink', glob("../public/img/{$table}/id_{$id}/*.*"));
            rmdir("../public/img/{$table}/id_$id");
        }
    }

    public function imgFullPath($table, $id, $imgName)
    {
        // delete the folder
        $this->deleteFolder($table, $id);
        // Create post folder
        if (!file_exists("../public/img/{$table}/id_$id")) {
            mkdir("../public/img/{$table}/id_$id");
        }
        $picProfile = $imgName;

        $upload_dir = "img/{$table}/id_$id/";
        $imgFullPath = $upload_dir . $picProfile;

        return $imgFullPath;
    }

    public function pagination($table, $id = 1, $limit = 5, $option = '')
    {
        /* Set current, prev and next page */
        $prev = ($id) - 1;
        $next = ($id) + 1;
        /* Calculate the offset */
        $offset = (($id * $limit) - $limit);
        /* Query the db for total results.*/
        $totalResults = $this->model->customQuery("SELECT COUNT(*) AS total FROM {$table}");
        $totalPages = ceil($totalResults->total / $limit);

        $orderBy = "ORDER BY id {$option} LIMIT $limit OFFSET $offset";
        $resultTable = $this->model->selectQuery($table, $orderBy);

        return [$prev, $next, $totalResults, $totalPages, $resultTable];
    }

    public function Mailer($sentFrom, $email, $name, $subject, $body, $cc = null, $pdf = null)
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
            $mail->Password   = '*********'; // SMTP password
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
            if ($pdf != null) {
                // $mail->addAttachment('/var/tmp/file.tar.gz');// Add attachments
                $mail->addAttachment($pdf);
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
