<?php
  require_once('../config.php');
  include("../mailer.php");
  include("connection.php");

  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $veri_code = substr(bin2hex(random_bytes(8)), 0, 8);

  // Check if the email already exists
  $check_email = $conn -> query("SELECT * FROM users WHERE username = '$email'");

  if($check_email -> num_rows > 0){
    echo "This email is already registered. Please use a different email.";

    exit();
  }else {
    $type = 2; // Set user type
    $avatar = "uploads/avatars/9.png";
    $query = $conn -> query(" INSERT INTO users (
      firstname, 
      lastname, 
      username, 
      password, 
      type, 
      avatar, 
      verification_code
    ) VALUES ('$firstname', '$lastname', '$email', '$password', $type, '$avatar', '$veri_code')");

    if ($query) {
      $_SESSION['user_id'] = $conn -> insert_id; // Get the newly inserted user id
      $_SESSION['firstname'] = $firstname;
      $_SESSION['lastname'] = $lastname;
      $_SESSION['password'] = $_POST['password'];
      $_SESSION['username'] = $email;

      sendEmail($email, $veri_code, $conn -> insert_id);

      echo "success";
      
      exit;
    } else {
      echo 'There was an error creating your account. Please try again.';
    }
  }
  $conn -> close();
?>