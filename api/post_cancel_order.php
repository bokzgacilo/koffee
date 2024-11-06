<?php
  include("connection.php");
  
  $orderid = $_POST['orderid'];

  $cancel = $conn -> query("UPDATE orders SET status='Cancelled' WHERE id=$orderid");

  if($cancel){
    echo "ok";
  }

  $conn -> close();
?>