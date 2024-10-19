<?php
  include("connection.php");

  $category_id = $_POST['category_id'];
  $product_name = $_POST['name'];
  $product_description = $_POST['description'];
  $product_price = $_POST['price'];
  $product_status = $_POST['status'];

  $target_dir = "../uploads/products/";
  $image_url = "";  

  if (isset($_FILES['image'])) {
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $originalFileName = $_FILES['image']['name'];
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $newFileName = $product_name . '.' . $fileExtension;

    $target_file = $target_dir . $newFileName;

    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $image_url = "/uploads/products/" . $newFileName;
  }

  $sizes = [];

  if(isset($_POST['sizeRadio'])){
    $sizes = $_POST['size[]'];
  }

  echo $image_url;

  $insert = $conn -> query("INSERT INTO product_list(
    category_id,
    name,
    description,
    price,
    image_url
  ) VALUES (
    $category_id,
    '$product_name',
    '$product_description',
    $product_price,
    '$image_url',
  )");

  if($insert){
    echo 'ok';
  }
  



  $conn -> close();
?>