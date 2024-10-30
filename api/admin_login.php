<?php
  session_start();

  include('connection.php');

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = $conn -> prepare("SELECT * FROM users WHERE username = ? AND password = ?");
  $sql -> bind_param("ss", $username, $password);
  $sql -> execute();

  $result = $sql -> get_result();

  if($result -> num_rows > 0){
    $_SESSION['adminauth'] = true;
    
    echo "ok";
  }else {
    echo "No match";
  }

  $conn -> close();
?>