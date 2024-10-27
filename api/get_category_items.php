<?php
  include("connection.php");

  $categoryId = $_GET['category_id'];

  $getAll = "";

  if($categoryId === "all"){
    $getAll = $conn -> query("SELECT * FROM product_list");
  }else {
    $getAll = $conn -> query("SELECT * FROM product_list WHERE category_id=$categoryId AND status=1");
  }


  if($getAll -> num_rows > 0){
    while($row = $getAll -> fetch_assoc()){
      $trimmed_value = str_replace(['Small', 'Large'], '', $row['name']);

      echo  "
      <div class='col-lg-3 col-6 menu-item'>
          <img src='./".$row['image_url']."' />
          <h3>".$trimmed_value."</h3>
          <p><strong>".number_format($row['price'], 2)."</strong></p>
          <a href='item.php?id=".$row['id']."' class='col col-12 btn btn-primary btn-lg'>BUY</a>
      </div>
      ";
    }
  }


  $conn -> close();
?>