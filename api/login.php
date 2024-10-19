<?php
  session_start();

  include('connection.php');

  $username = $_POST['email'];
  $password = $_POST['password'];
  $is_verify = true;

  $sql = $conn -> prepare("SELECT * FROM users WHERE username = ? AND password = ?");
  $sql -> bind_param("ss", $username, $password);
  $sql -> execute();

  $result = $sql -> get_result();

  if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()){
      if($row['is_verify']){
        $_SESSION['userid'] = $row['id'];
        $_SESSION['userfullname'] = $row['firstname'] . " " . $row['lastname'];
        $_SESSION['useremail'] = $row['username'];
        $_SESSION['avatar'] = $row['avatar'];
  
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