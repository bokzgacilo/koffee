<?php
  session_start();

  include('connection.php');

  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = $conn -> prepare("SELECT * FROM users WHERE username = ? AND password = ? AND type=1");
  $sql -> bind_param("ss", $username, $password);
  $sql -> execute();

  $result = $sql -> get_result();

  if($result -> num_rows > 0){
    $user = $result -> fetch_assoc();

    $_SESSION['adminauth'] = true;
    $_SESSION['adminid'] = $user['id'];
    $_SESSION['adminavatar'] = $user['avatar'];
    $_SESSION['adminname'] = $user['firstname'];

    echo "ok";
  }else {
    echo "No match";
  }

  $conn -> close();
?>