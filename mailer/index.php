<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);


//variables
$mySubject = $_POST['mySubject'];
$myBody = $_POST['myBody'];
$toEmail = $_POST['email'];
$toName = $_POST['name'];

// $mySubject = "iConsult Test Message";
// $myBody = "This is a sample message for later integration.";
// $toEmail = "michaelsabado.ms04@gmail.com";
// $toName = "Michael Sabado";




try {
    // Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = 'gradeguru.ph@gmail.com'; // YOUR gmail email
    $mail->Password = 'valorant'; // YOUR gmail password

    // Sender and recipient settings
    $mail->setFrom('gradeguru.ph@gmail.com', 'Grade Guru');
    $mail->addAddress($toEmail, $toName);
    $mail->addReplyTo('gradeguru.ph@gmail.com', 'Grade Guru'); // to set the reply to

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = $mySubject;
    $mail->Body = $myBody;


    $mail->send();
    echo 1;
} catch (Exception $e) {
    echo "Error " . $e;
}
