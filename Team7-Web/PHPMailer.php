<?php
    require 'PHPMailer/vendor/phpmailer/src/Exception.php';
    require 'PHPMailer/vendor/phpmailer/src/PHPMailer.php';
    require 'PHPMailer/vendor/phpmailer/src/SMTP.php';
    require 'PHPMailer/vendor/autoload.php';

    //Server settings
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->CharSet = "UTF-8"; 
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 's6102041610041@email.kmutnb.ac.th';
    $mail->Password   = 'gaggod2000';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->isHTML(true);
?>