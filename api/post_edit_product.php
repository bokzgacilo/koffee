<?php
  include("connection.php");

  $productid = $_POST['productid'];
  $product_name = $_POST['name'];
  $product_description = $_POST['description'];
  $product_price = $_POST['price'];
  $product_status = $_POST['status'];

  $getimageurl = $conn -> query("SELECT image_url FROM product_list WHERE id=$productid");
  $image = $getimageurl -> fetch_assoc();

  $target_dir = "../uploads/products/";
  $image_url = "";  

  if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $originalFileName = $_FILES['image']['name'];
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $newFileName = $product_name . '.' . $fileExtension;

    $target_file = $target_dir . $newFileName;

    // Move the uploaded file
    if (move_uploaded_file($fileTmpPath, $target_file)) {
        // File uploaded successfully, set new image URL
        $image_url = "/uploads/products/" . $newFileName;
    } else {
        // Handle error during upload if needed
        echo "Error moving the uploaded file.";
    }
  } else {
      // No file uploaded, keep the current image URL (from database or a default value)
      $image_url = $image['image_url']; // Assume $current_image_url is fetched from the database or previous value
  }

  $insert = $conn -> query("UPDATE product_list SET status='$product_status', name='$product_name', description='$product_description', price=$product_price, image_url='$image_url' WHERE id=$productid");

  if($insert){
    echo 'ok';
  }
  
  $conn -> close();
?>