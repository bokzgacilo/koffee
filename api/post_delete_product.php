<?php
  include("connection.php");
  
  $id = $_POST['id'];

  $delete = $conn -> query("DELETE FROM product_list WHERE id=$id");

  if($id){
    echo "ok";
  }

  $conn -> close();
?>