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

  $sizes_json = [];
  $s = "";

  if(!$_POST['sizeRadio']){
    $s = "";
  }else {
    $sizes = $_POST['size'];
    $length = count($sizes);

    for ($i=0; $i < $length; $i++) { 
      $size_json = [];
      switch($sizes[$i]){
        case 'small' :
          $size_json = [
            'size' => 'small',
            'price' => $_POST['small_price']
          ];
          break;
        case 'regular' :
          $size_json = [
            'size' => 'regular',
            'price' => $_POST['regular_price']
          ];
          break;
        case 'large' :
          $size_json = [
            'size' => 'large',
            'price' => $_POST['large_price']
          ];
          break;
      }

      $sizes_json[] = $size_json;
      $s = json_encode($sizes_json);
    }
  }

  $insert = $conn -> query("INSERT INTO product_list(
    category_id,
    name,
    description,
    price,
    image_url,
    size_price
  ) VALUES (
    $category_id,
    '$product_name',
    '$product_description',
    $product_price,
    '$image_url',
    '$s'
  )");


  if($insert){
    echo 'ok';
  }
  
  $conn -> close();
?>