<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'lib/PHPMailer/src/Exception.php';
require 'lib/PHPMailer/src/PHPMailer.php';
require 'lib/PHPMailer/src/SMTP.php';

class Mail_sender{
    public $mail;

    public function send_mail($last_name, $receiver_mail, $code){
        $this->mail = new PHPMailer(true);
        try {
            //Server settings
            //$mail->SMTPDebug = 2;                               // Enable verbose debug output
            $this->mail->isSMTP();                                // Set mailer to use SMTP
            $this->mail->Host = 'smtp.mailtrap.io';               // Specify main and backup SMTP servers
            $this->mail->SMTPAuth = true;                         // Enable SMTP authentication
            $this->mail->Username = 'a8708d956d2e34';             // SMTP username
            $this->mail->Password = '01579f1934d78c';             // SMTP password
            $this->mail->SMTPSecure = 'tls';                      // Enable TLS encryption, `ssl` also accepted
            $this->mail->Port = 2525;                             // TCP port to connect to  587




            //Recipients
            $this->mail->setFrom('admin@blog.com', 'admin');
            $this->mail->addAddress("$receiver_mail", "Mr "."$last_name");     // Name is optional


            //Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = 'Account verification for Blog';
            $this->mail->Body    = "<style>body{text-align: center;font-family: Arial;}h1{font-family: Arial;} p{font-family: Arial;border: solid black;border-radius: 12px;margin-left: auto;margin-right: auto;width: 30%;padding: 30px;}".
                "</style><body><h1>Hello $last_name</h1><p>This is the mail from Blog group.<br/>We are glad your are here<br/> We just want to <b>verify</b> your account<br/>Click the verification link:".
                "<a href=http://localhost/codeboxr/socialmedia/login_ajax.php?verification=1&code=$code>Link</a></p></body>";
            $this->mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $this->mail->ErrorInfo;
        }
    }
}