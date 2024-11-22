<?php
  include("connection.php");

  $orderID = $_POST['id'];

  if($conn -> query("UPDATE orders SET status='Cancelled' WHERE id=$orderID") === true){
    echo "Cancel Order";
  }else {
    echo "Error processing order. Please try again";
  }

  $conn -> close();
?>