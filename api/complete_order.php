<?php
  include("connection.php");

  $orderID = $_POST['orderidc'];
  

  $targetDir = "uploads/proofs/";

  $file = $_FILES['proof_of_order'];
  $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
  $targetFile = $targetDir . $orderID . '.' . $fileExtension; 
  $imagepath = "";

  if ($file['error'] === UPLOAD_ERR_OK) {
    if (move_uploaded_file($file['tmp_name'],  "../$targetFile")) {
      $imagepath = $targetFile;
    }
  }

  if($conn -> query("UPDATE orders SET status='Completed', proof_of_order='$imagepath' WHERE id=$orderID") === true){
    echo "Order Completed";
  }else {
    echo "Error processing order. Please try again";
  }

  $conn -> close();
?>