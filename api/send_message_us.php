<?php
  include("connection.php");

  require '../vendor/autoload.php';

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  $mail = new PHPMailer(true);

  $customer_name = $_POST['name'];
  $customer_email = $_POST['email'];
  $customer_body = $_POST['body'];

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
    $mail->setFrom('koffeemailer@gmail.com', 'Kofee Manila Automated Email');
  
    $mail->addAddress('koffeemailer@gmail.com', 'Kofee Manila Automated Email');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = "Automated Email By $customer_name";
    $mail->Body = "
    Client Name: $customer_name <br>
    Client Email: $customer_email <br>
    <br><br>
    $customer_body
    ";

    // Send the email
    $mail -> send();

    echo "ok";
  } catch (Exception $e) {
    exit();
  }
  
  $conn -> close();
?>