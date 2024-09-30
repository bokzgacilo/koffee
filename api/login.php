<?php
  session_start();

  include('connection.php');

  $username = $_POST['username'];
  $password = $_POST['password']; // Hash the entered password with MD5

  $sql = $conn -> prepare("SELECT * FROM users WHERE username = ? AND password = ?");
  $sql -> bind_param("ss", $username, $password);
  $sql -> execute();

  $result = $sql -> get_result();

  while($row = $result -> fetch_assoc()){
    if($row){
      $_SESSION['userid'] = $row['id'];

      echo 1;
    }else {
      echo "No match";
    }
  }

  $conn -> close();
?>