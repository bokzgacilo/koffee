<?php
  include("connection.php");
  
  $orderid = $_POST['orderid'];

  $order = $conn -> query("SELECT * FROM orders WHERE id=$orderid LIMIT 1");
  $order = $order -> fetch_assoc();

  $conn -> query("INSERT INTO refund(order_id, client_id, amount, gcash_receipt, gcash_reference) VALUES(
    $orderid,
    ".$order['client_id'].",
    ".$order['price'].",
    '".$order['gcash']."',
    '".$order['reference_number']."'
  )");

  $cancel = $conn -> query("UPDATE orders SET status='Cancelled' WHERE id=$orderid");

  if($cancel){
    echo "ok";
  }

  $conn -> close();
?>