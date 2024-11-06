<style>
  .container-fluid {
    background-color: #fff;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  #detail {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  #detail > div {
    display: flex;
    flex-direction: row;
  }

  #detail > div > p {
    margin: 0;
  }

  #detail > .receipt {
    display: flex;
    flex-direction: column;
  }

  .receipt > img {
    width: 120px;
    height: auto;
    object-fit: cover;
  }

  #detail > div > p:first-of-type {
    font-weight: 500;
  }
</style>

<div class="container-fluid">
  <h1>List of Orders</h1>
  <div class="d-flex flex-row">
    <div class="col-7">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Client ID</th>
          <th>Order Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include("../api/connection.php");

          $result = $conn -> query("SELECT * FROM orders");

          $buttonRenderer = "";

          if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
              $status_message = "";

              switch($row['status']){
                case 'Pending' :
                  $status_message = "<button onclick='prepareOrder(".$row['id'].")' class='btn btn-sm btn-primary'>Prepare Order</button>";
                  break;
                case 'Preparing' :
                  $status_message = "<button onclick='deliverOrder(".$row['id'].")' class='btn btn-sm btn-primary'>Deliver Order</button>";
                  break;
                case 'In-Delivery' :
                  $status_message = "<button onclick='completeOrder(".$row['id'].")' class='btn btn-sm btn-primary'>Complete Order</button>";
                  break;
                case 'Cancelled' :
                  $status_message = "";
                  break;
                case 'Completed' :
                  $status_message = "<button disabled class='btn btn-sm btn-success'>Completed</button>";
                  break;
                  default:
                $status_message = "Unknown status.";
                break;
              }

              $clientid = $row['client_id'];
              $getclientname = $conn -> query("SELECT * FROM users WHERE id=$clientid");
              $client = $getclientname -> fetch_assoc();
              
              echo "
                <tr>
                  <td>".$row['id']."</td>
                  <td>".$client['lastname'].", ".$client['firstname']."</td>
                  <td>".$row['order_date']."</td>
                  <td>".$row['status']."</td>
                  <td>
                    <button onclick='viewOrder(".$row['id'].")' class='btn btn-sm btn-secondary'>View Order</button>
                    $status_message
                  </td>
                </tr>
              ";
            }
          }
        ?>
      </tbody>
    </table>
    </div>
    <div class="col-5" id="detail">

    </div>
  </div>
  
</div>

<script type="module">
  import {updateDocument} from "./firebase.js"

  window.prepareOrder = function(id){
    Swal.fire({
      title: "Do you want prepare this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Prepare",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "../api/prepare_order.php",
          data : {
            id: id
          },
          success : response => {
            console.log(id)
            updateDocument(id, "Your order was being prepared.")

            setTimeout(() => {
              alert('Order Updated');

              location.reload();
            }, 3000)
          }
        })
      }
    });
  }

  window.deliverOrder = function(id){
    Swal.fire({
      title: "Do you want deliver this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Deliver",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "../api/deliver_order.php",
          data : {
            id: id
          },
          success : response => {
            console.log(id)
            updateDocument(id, "Order is on the way to you!")
            setTimeout(() => {
              alert('Order Updated');

              location.reload();
            }, 3000)
          }
        })
      }
    });
  }

  window.completeOrder = function(id){
    Swal.fire({
      title: "Do you want complete this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Complete",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "../api/complete_order.php",
          data : {
            id: id
          },
          success : response => {
            console.log(id)
            updateDocument(id, "Order completed!")
            

            setTimeout(() => {
              alert('Order Updated');

              location.reload();
            }, 3000)
            
          }
        })
      }
    });
  }
 

  window.viewOrder = function(id){
    $.ajax({
      type: 'get',
      url: '../api/get_order_details.php',
      data: {
        id:id
      },
      success: response => {
        $("#detail").html(response)
      }
    })
  }

	$(document).ready(function(){
		
	})
</script>