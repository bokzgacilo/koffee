<?php
  session_start();
  include('connection.php');

  $contact1 = $_POST['contact_number1'];
  $contact2 = $_POST['contact_number2'];
  $client_id = $_POST['client_id'];
  $gcash = $_POST['gcash'];
  $reference_number = $_POST['reference_number'];
  $cart = json_encode($_POST['cart']);
  $address = $_POST['address'];
  $nearest_landmark = $_POST['nearest_landmark'];
  $map = $_POST['map'];
  $price = $_POST['price'];

  $sql = "INSERT INTO orders(
    cart, 
    client_id, 
    address, 
    contact_1, 
    contact_2, 
    map, 
    nearest_landmark,
    price,
    order_date,
    status,
    reference_number,
    gcash
  ) VALUES(
    '$cart', 
    $client_id, 
    '$address', 
    '$contact1', 
    '$contact2', 
    '$map', 
    '$nearest_landmark',
    $price,
    NOW(),
    'Pending',
    '$reference_number',
    '$gcash'
  )";

  if($conn -> query($sql)){
    echo "Success";

    $id = $_SESSION['userid'];
    $conn -> query("UPDATE users SET cart='' WHERE id=$id");
  }else {
    echo "Failed";
  }

  $conn -> close();
?>