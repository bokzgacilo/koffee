<?php
  include("../../api/connection.php");
  $orderid = $_POST['orderid'];

  $conn -> query("UPDATE orders SET status='Refunded' WHERE id=$orderid");
  $refund = $conn -> query("UPDATE refund SET status='Refunded' WHERE order_id=$orderid");

  if($refund){
    echo "ok";
  }

  $conn -> close();
?>