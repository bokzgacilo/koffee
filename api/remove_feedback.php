<?php
  include("connection.php");

  $feedbackid = $_POST['id'];

  if($conn -> query("DELETE FROM customer_feedback WHERE id=$feedbackid") === true){
    echo "ok";
  }

  $conn -> close();
?>