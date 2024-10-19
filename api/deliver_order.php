<?php
  include("connection.php");

  $orderID = $_POST['id'];

  if($conn -> query("UPDATE orders SET status='In-Delivery' WHERE id=$orderID") === true){
    echo "Delivering Order";
  }else {
    echo "Error processing order. Please try again";
  }

  $conn -> close();
?>