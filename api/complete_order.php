<?php
  include("connection.php");

  $orderID = $_POST['id'];

  if($conn -> query("UPDATE orders SET status='Completed' WHERE id=$orderID") === true){
    echo "Order Completed";
  }else {
    echo "Error processing order. Please try again";
  }

  $conn -> close();
?>