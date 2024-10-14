<?php
  session_start();

  include('connection.php');

  $username = $_POST['username'];
  $password = $_POST['password']; // Hash the entered password with MD5
  $is_verify = true;

  $sql = $conn -> prepare("SELECT * FROM users WHERE username = ? AND password = ?");
  $sql -> bind_param("ss", $username, $password);
  $sql -> execute();

  $result = $sql -> get_result();

  if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()){
      if($row['is_verify']){
        $_SESSION['userid'] = $row['id'];
  
        echo "Logged In Successfully";
      }else {
        echo "Need to verify account first";
      }
    }
  }else {
    echo "No match";
  }

  $conn -> close();
?>