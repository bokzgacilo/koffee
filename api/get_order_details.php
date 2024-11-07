<?php
  include("connection.php");

  $id = $_GET['id'];

  $result = $conn -> query("SELECT * FROM orders WHERE id=$id");

  if($result -> num_rows > 0){
    echo "<h3>Order Details</h3>";

    while($row = $result -> fetch_assoc()){
      $cart = json_decode($row['cart'], true);

      echo "
        <table class='table table-responsive w-100'>
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
        <div class='row'>
          <h6 class='col-4'>Total Price </h6>
          <p class='col-8'>".$row['price']."</p>
        </div>
        <div class='row'>
          <h6 class='col-4'>Client Name </h6>
          <p class='col-8'>".$row['client_id']."</p>
        </div>
        <div class='row'>
          <h6 class='col-4'>Delivery Addres </h6>
          <p class='col-8'>".$row['address']."</p>
        </div>
        <div class='row'>
          <h6 class='col-4'>Contact 1 </h6>
          <p class='col-8'>".$row['contact_1']."</p>
        </div>
        <div class='row'>
          <h6 class='col-4'>Contact 2 </h6>
          <p class='col-8'>".$row['contact_2']."</p>
        </div>
        <div class='row'>
          <h6 class='col-4'>Nearest Landmark </h6>
          <p class='col-8'>".$row['nearest_landmark']."</p>
        </div>
        <div class='row'>
          <h6 class='col-4'>Pin Location</h6>
          <p class='col-8'>".$row['map']."</p>
        </div>
        <div class='row'>
          <p class='col-4'>Status</p>
          <p class='col-8'>".$row['status']."</p>
        </div>
        <div class='row'>
          <p class='col-4'>GCash Reference Number</p>
          <p class='col-8'>".$row['reference_number']."</p>
        </div>
        <div class='row'>
          <h6 class='col-4'>Date Ordered</h6>
          <p lass='col-8'>".$row['order_date']."</p>
        </div>
         <div class='image-container border mb-3 p-3'>
            <img id='image' src='".$row['gcash']."' class='img-fluid'>
        </div>
        <div class='controls'>
            <button id='zoomIn' class='btn btn-primary btn-sm mr-2'>Zoom In</button>
            <button id='zoomOut' class='btn btn-primary btn-sm'>Zoom Out</button>
        </div>
        <div class='pan-controls'>
            <button id='panUp' class='btn btn-primary mr-2'>&#8593;</button><br>
            <button id='panLeft' class='btn btn-primary mr-2'>&#8592;</button>
            <button id='panRight' class='btn btn-primary mr-2'>&#8594;</button><br>
            <button id='panDown' class='btn btn-primary'>&#8595;</button>
        </div>

        <style>
          .image-container {
              width: 500px;
              height: 500px;
              overflow: hidden;
              position: relative;
          }

          .image-container img {
              transition: transform 0.1s ease;
              position: absolute;
              top: 0;
              left: 0;
          }
        </style>
      ";
    }
  }

  

  $conn -> close();
?>