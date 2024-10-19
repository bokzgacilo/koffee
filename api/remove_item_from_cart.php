<?php
  include("connection.php");
  session_start();

  $item_name = $_POST['item'];
  
  $select_user = $conn -> query("SELECT * FROM users WHERE id='".$_SESSION['userid']."'");
  
  if($select_user -> num_rows > 0){
    $row = $select_user -> fetch_assoc();

    $cartArray = json_decode($row['cart'], true);

    if (!empty($cartArray)) {

      // Define the product to remove (for example, by productName)
      $productNameToRemove = $item_name; // The product name you want to remove

      // Loop through the cart and remove the item with the matching product name
      foreach ($cartArray as $key => $item) {
          if ($item['productName'] == $productNameToRemove) {
            unset($cartArray[$key]); // Remove the item from the array
            break; // Stop the loop once the item is found and removed
          }
      }

      // Re-index the array to remove gaps in keys
      $cartArray = array_values($cartArray);

      // Encode the modified cart array back to JSON
      $updatedCartJson = json_encode($cartArray);

      $updateSql = $conn -> query("UPDATE users SET cart = '$updatedCartJson' WHERE id = '".$_SESSION['userid']."'");

      if($updatedCartJson === true){
        echo "updated";
      }
    }
  }
  

  $conn -> close();
?>