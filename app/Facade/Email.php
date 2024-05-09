<?php

declare(strict_types=1);

namespace App\Facade;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
  // Email start
  public function sendEmailHandler($data, $attachment = null)
  {
    $name = strip_tags($data['name']);
    $email = strip_tags($data['email']);
    $subject = strip_tags($data['subject']);
    $bodyStriped = strip_tags($data['body']);

    $body = "<b>{$name}</b> com email <b>{$email}</b><p>Enviou:</p><p>{$bodyStriped}</p>";

    return $this->Mailer($email, 'marcos_sco@outlook.com', $name, $subject, $body, 1, $attachment);
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
      $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      //sender
      $mail->setFrom(utf8_decode($sentFrom), utf8_decode($subject));
      // reciver
      $mail->addAddress(utf8_decode($email), utf8_decode($name));     // Add a recipient
      // $mail->addAddress('marcosXsco@gmail.com');               // Name is optional
      $mail->addReplyTo(utf8_decode($sentFrom), "Responder {$sentFrom}");

      if ($cc != null) $mail->addCC('marcosXsco@gmail.com');

      //$mail->addCC('cc@example.com');
      //$mail->addBCC('bcc@example.com');

      // Attachments
      if ($attachment != null) {
        // $mail->addAttachment('/var/tmp/file.tar.gz');// Add attachments
        $mail->addAttachment($attachment['tmp_name'], utf8_decode($attachment['name']), 'base64', $attachment['type']);
      }

      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

      // Content
      $mail->isHTML(true); // Set email format to HTML
      $mail->Subject = utf8_decode($subject);
      $mail->Body    = utf8_decode($body);
      $striped = strip_tags(utf8_decode($body));
      $mail->AltBody = "{$striped}";

      $mail->send();
      // echo 'Message has been sent';

      // $this->Mailer('marcosXsco@gmail.com', $email, $name, "{$name} sua mensagem foi enviada", "</br>Olá {$name}, Obrigado por enviar sua mensagem.<p>Em breve entraremos em contato!</p>", null, $attachment);

    } catch (\Exception $e) {

      return [
        'error' => true,
        'message' => "Message could not be sent. Mailer Error: " . $mail->ErrorInfo
      ];
    }
  }
}
