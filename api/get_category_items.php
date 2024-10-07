<?php
  include("connection.php");

  $categoryId = $_GET['category_id'];

  $getAll = "";

  if($categoryId === "all"){
    $getAll = $conn -> query("SELECT * FROM product_list");
  }else {
    $getAll = $conn -> query("SELECT * FROM product_list WHERE category_id=$categoryId");
  }


  if($getAll -> num_rows > 0){
    while($row = $getAll -> fetch_assoc()){
      $trimmed_value = str_replace(['Small', 'Large'], '', $row['name']);

      echo  "
      <div class='col-4'>
        <div class='menu-item'>
          <img src='uploads/products/2022-04-22_10-18-15.png' />
          <h3>".$trimmed_value."</h3>
          <p><strong>".number_format($row['price'], 2)."</strong></p>
          <a href='item.php?id=".$row['id']."' class='col col-12 btn btn-primary btn-lg'>BUY</a>
        </div>
      </div>
      ";
    }
  }


  $conn -> close();
?>