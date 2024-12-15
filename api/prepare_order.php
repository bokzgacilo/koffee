<?php
  include("connection.php");

  $orderID = $_POST['orderid'];
  $staff = $_POST['selectstaff'];

  if($conn -> query("UPDATE orders SET status='Preparing', prepared_by='$staff' WHERE id=$orderID") === true){
    echo "Preparing Order";
  }else {
    echo "Error processing order. Please try again";
  }

  $conn -> close();
?>