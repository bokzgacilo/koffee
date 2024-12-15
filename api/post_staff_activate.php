<?php
  include("connection.php");

  $staffid = $_POST['staffid'];

  $update = $conn -> query("UPDATE staff SET is_active=true WHERE id=$staffid");

  if($update){
    echo "ok";
  }

  $conn -> close();

?>