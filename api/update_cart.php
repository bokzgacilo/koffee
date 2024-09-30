<?php
  include("connection.php");
  header('Content-Type: application/json');
  $rawData = file_get_contents('php://input');
  $data = json_decode($rawData, true);

  $userid = $data['userid'];
  $cart_item = $data['cart_item'];

  $sql = $conn -> prepare("SELECT cart FROM users WHERE id = ?");
  $sql -> bind_param('i', $userid);
  $sql -> execute();

  $result = $sql -> get_result();
  $row = $result -> fetch_assoc();
  if($row){
    $cart = [];

    if($row['cart']){
      $cart = json_decode($row['cart'], true);
    }

    $item_exists = false;

    foreach($cart as &$item){
      if($item['productName'] === $cart_item['productName']){
        $item['quantity'] += $cart_item['quantity'];
        $item['totalPrice'] += $cart_item['totalPrice'];
        $item_exists = true;

        break;
      }
    }

    if(!$item_exists){
      $cart[] = $cart_item;
    }


    $updated_json = json_encode($cart);

    $update = $conn -> prepare("UPDATE users SET cart = ? WHERE id = ?");
    $update -> bind_param("si", $updated_json, $userid);

    if($update -> execute()){
      echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
    }else {
      echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
    }

    $update -> close();
  }
  
  $sql -> close();
  $conn -> close();
?>