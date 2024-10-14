<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create a new PHPMailer instance

function sendEmail($client_email, $verification_code, $userid){
  $mail = new PHPMailer(true);

  try {
    // Set up PHPMailer
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'koffeemailer@gmail.com'; // Your Gmail address
    $mail->Password = 'uwcpgyngofwqeurb'; // Your Gmail App Password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Set the sender and recipient
    $mail->setFrom('koffeemailer@gmail.com', 'Kofee Manila Support');
  
    $mail->addAddress($client_email);

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Verification Required';
    $mail->Body = "
        <p>Please click the link to verify your registration.</p>
        <a href='localhost/koffee/verify.php?code=$verification_code&userid=$userid'>Verify Registration</a>
    ";

    // Send the email
    $mail -> send();

    return true;
  } catch (Exception $e) {
    return false;
    exit();
  }
}
?>