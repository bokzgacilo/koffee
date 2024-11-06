<?php
  include("connection.php");
  session_start();
  $orderid = $_GET['orderid'];

  $select = $conn -> query("SELECT * FROM orders WHERE id=$orderid");

  $select = $select -> fetch_assoc();

  $cart_item = json_decode($select['cart'], true);

  $status_message = "";

  switch($select['status']){
    case 'Pending' :
      $status_message = "We have received your order and it is awaiting confirmation.";
      break;
    case 'Preparing' :
      $status_message = "Our chefs are working on it right now.";
      break;
    case 'In-Delivery' :
      $status_message = "The delivery person is heading to your location.";
      break;
    case 'Cancelled' :
      $status_message = "Cancelled!";
      break;
    case 'Completed' :
      $status_message = "Your order has been delivered! We hope you enjoy your meal.";
      break;
      default:
    $status_message = "Unknown status.";
    break;
  }

  echo "
    <div class='modal-header'>
      <h5 class='modal-title'>Show Order</h5>
    </div>
    <div class='modal-body'>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>Items</h6>
        </div>
        <div class='col-7'>";
        foreach ($cart_item as $item) {
          echo "<h6>".$item['productName']."</h6>";
        }
        echo "</div>
      </div>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>Order ID</h6>
        </div>
        <div class='col-7'>
          <h6>".$select['id']."</h6>
        </div>
      </div>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>Status</h6>
        </div>
        <div class='col-7'>
          <h6>$status_message</h6>
        </div>
      </div>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>Address</h6>
        </div>
        <div class='col-7'>
          <h6>".$select['address']."</h6>
        </div>
      </div>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>Nearest Landmark</h6>
        </div>
        <div class='col-7'>
          <h6>".$select['nearest_landmark']."</h6>
        </div>
      </div>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>Contact Number 1</h6>
        </div>
        <div class='col-7'>
          <h6>".$select['contact_1']."</h6>
        </div>
      </div>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>Contact Number 2</h6>
        </div>
        <div class='col-7'>
          <h6>".$select['contact_2']."</h6>
        </div>
      </div>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>GCash Reference</h6>
        </div>
        <div class='col-7'>
          <h6>".$select['reference_number']."</h6>
        </div>
      </div>
      <div class='row'>
        <div class='col-5'>
          <h6 style='font-weight: bold;'>GCash Receipt</h6>
        </div>
        <div class='col-7'>
          <img width='100%' height='auto' src='".$select['gcash']."' />
        </div>
      </div>
    </div>

    <div class='modal-footer'>";
      if($select['status'] === "Completed"){
        echo "<button type='button' class='btn btn-success' id='leaveReviewButton'>Leave Review</button>";
      }else {
        if($select['status'] !== "Cancelled"){
          echo "<button type='button' class='btn btn-danger' id='cancelButton'>Cancel</button>";
        }
      }
      echo "<button type='button' class='btn btn-primary' data-bs-dismiss='modal'>Close</button>
    </div>
  ";

  echo "
    <script>
      $(document).on('click', '#leaveReviewButton',function(){
        $('#userid').val('".$select['id']."')
        $('#useremail').val('".$_SESSION['useremail']."')
        $('#orderid').val('$orderid')

        $('#leaveReviewModal').modal('toggle')
        $('#viewOrderModal').modal('toggle')
      })

      $(document).on('click', '#cancelButton',function(){
        $.ajax({
          type: 'post',
          url: 'api/post_cancel_order.php',
          data: {
            orderid: $orderid
          },
          success: response => {
            if(response === 'ok'){
              alert('Order Cancelled!')

              location.reload();
            }
          }
        })
      })
    </script>
  ";

  $conn -> close();
?>