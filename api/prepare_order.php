<?php
  include("connection.php");

  $orderID = $_POST['id'];

  if($conn -> query("UPDATE orders SET status='Preparing' WHERE id=$orderID") === true){
    echo "Preparing Order";
  }else {
    echo "Error processing order. Please try again";
  }

  $conn -> close();
?>