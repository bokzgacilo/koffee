<?php
  include("connection.php");

  $staffname = $_POST['staffname'];

  $add = $conn -> query("INSERT INTO staff(name) VALUES('$staffname')");

  if($add){
    echo "ok";
  }

  $conn -> close();

?>