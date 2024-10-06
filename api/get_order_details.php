<?php
  include("connection.php");

  $id = $_GET['id'];

  $result = $conn -> query("SELECT * FROM orders WHERE id=$id");

  if($result -> num_rows > 0){
    echo "<h3>Order Details</h3>";

    while($row = $result -> fetch_assoc()){
      $cart = json_decode($row['cart'], true);

      echo "
        <table class='table table-bordered'>
        <thead>
          <tr>
            <th>Name</th>
            <th>Quantity</th>
            <th>Size</th>
            <th>Addon</th>
            <th>Instruction</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>";
        foreach ($cart as $item) {
          echo " <tr><td>" . $item['productName'] . "</td>";
          echo "<td>" . $item['quantity'] . "</td>";
          echo "<td>" . $item['size'] . "</td>";
          echo "<td>" . $item['addon'] . "</td>";
          echo "<td>" . $item['instructions'] . "</td>";
          echo "<td>" . $item['totalPrice'] . "</td></tr>";
        }
        echo "</tbody>
        </table>
      ";


      echo "
        <div>
          <p>Total Price </p>
          <p>".$row['price']."</p>
        </div>
        <div>
          <p>Client Name </p>
          <p>".$row['client_id']."</p>
        </div>
        <div>
          <p>Delivery Addres </p>
          <p>".$row['address']."</p>
        </div>
        <div>
          <p>Contact 1 </p>
          <p>".$row['contact_1']."</p>
        </div>
        <div>
          <p>Contact 2 </p>
          <p>".$row['contact_2']."</p>
        </div>
        <div>
          <p>Nearest Landmark </p>
          <p>".$row['nearest_landmark']."</p>
        </div>
        <div>
          <p>Pin Location</p>
          <p>".$row['map']."</p>
        </div>
        <div>
          <p>Status: </p>
          <p>".$row['status']."</p>
        </div>
        <div>
          <p>GCash Reference Number: </p>
          <p>".$row['reference_number']."</p>
        </div>
        <div class='receipt'>
          <p>Gcash Receipt</p>
          <img src='".$row['gcash']."'>
        </div>
        <div>
          <p>Date Ordered</p>
          <p>".$row['order_date']."</p>
        </div>
      ";
    }
  }

  

  $conn -> close();
?>