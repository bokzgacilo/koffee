<?php
  session_start();
  include('connection.php');

  $contact1 = $_POST['contact_number1'];
  $contact2 = $_POST['contact_number2'];
  $client_id = $_POST['client_id'];

  $address = $_POST['block_number'] . ", " . $_POST['street_name'] . ", " . $_POST['barangay'] . ", " . $_POST['city'];

  $reference_number = $_POST['reference_number'];

  $user = $conn -> query("SELECT cart FROM users WHERE id=$client_id");
  $user = $user -> fetch_assoc();

  $cart = json_decode($user['cart'], true);
  $cart_string = $user['cart'];

  $nearest_landmark = $_POST['nearest_landmark'];
  $pin_location = $_POST['nearest_landmark'];
  $price = $_POST['price'];

  $image_url = "";
  
  if(isset($_FILES['gcash'])){
    $target_dir = "/uploads/gcash/";
    $targetFile =  $target_dir . $client_id. "-" . $reference_number . basename($_FILES['gcash']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    move_uploaded_file($_FILES["gcash"]["tmp_name"], "../" . $targetFile);

    $image_url = $targetFile;
  }

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
    '$cart_string', 
    $client_id, 
    '$address', 
    '$contact1', 
    '$contact2', 
    '$pin_location', 
    '$nearest_landmark',
    $price,
    NOW(),
    'Pending',
    '$reference_number',
    '$image_url'
  )";

  if($conn -> query($sql)){
    $newOrderId = $conn -> insert_id;

    foreach($cart as $item){
      $oldnumber = $conn -> query("SELECT sold FROM product_list WHERE name='".$item['productName']."'");
      $oldnumber = $oldnumber -> fetch_assoc();

      $newquantity = $item['quantity'] + $oldnumber['sold'];

      $conn -> query("UPDATE product_list SET sold=$newquantity WHERE name='".$item['productName']."'");
    }

    echo $newOrderId;

    $id = $_SESSION['userid'];
    $_SESSION['cart'] = "";
    $conn -> query("UPDATE users SET cart='' WHERE id=$id");
  }else {
    echo "Failed";
  }

  $conn -> close();
?>