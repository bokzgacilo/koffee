<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KOFEE MANILA</title>
  <script src="libs/jquery.js"></script>
  <script src="libs/popper.js"></script>

  <script src="libs/bootstrap.min.js"></script>
  <link href="libs/bootstrap.min.css" rel="stylesheet" />

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body>
  <!-- Navbar Section -->
  <?php include "includes/navbar.php"; ?>

  <!-- View Order modal -->
  <div class="modal fade" id="viewOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" id="viewOrderModalBody">

        
      </div>
    </div>
  </div>

  <!-- Leave a Review Modal -->
  <div class="modal fade" id="leaveReviewModal" tabindex="-1" aria-labelledby="leaveReviewLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="leaveReviewLabel">Leave a Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Review form -->
          <form id="reviewForm">
            <input type="hidden" id="userid" value="0" />
            <input type="hidden" id="useremail" value="0" />

            <div class="mb-3">
              <label for="reviewText" class="form-label">Review</label>
              <textarea class="form-control" id="review" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="rating" class="form-label">Rating</label>
              <select class="form-select" id="rating" required>
                <option value="" selected disabled>Choose...</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Terrible</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Image Background Cover Section -->
  <section class="bg-image">
    <div class="container text-center py-5">
      <div class="p-4 text-white">
        <h1>Welcome to Kofee Manila</h1>
        <p>A cozy place to enjoy the finest coffee.</p>
      </div>
    </div>
  </section>

  <!-- Orders Table Section -->
  <section class="container my-5">
    <h2 class="mb-4">Orders</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Status</th>
          <th>Order</th>
          <th>Price</th>
          <th>Order Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include("api/connection.php");

          $result = $conn -> query("SELECT * FROM orders WHERE client_id='".$_SESSION['userid']."'");
          if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
              $cart = json_decode($row['cart'], true);

              $status_message = "";

              switch($row['status']){
                case 'Pending' :
                  $status_message = "Your order is pending.";
                  break;
                case 'Preparing' :
                  $status_message = "Your order is being prepared.";
                  break;
                case 'In-Delivery' :
                  $status_message = "Your order is on its way!";
                  break;
                case 'Completed' :
                  $status_message = "Your order has been delivered!";
                  break;
                  default:
                $status_message = "Unknown status.";
                break;
              }

              echo "
                <tr class='view-order-cell' data-target='".$row['id']."'>
                  <td>".$row['id']."</td>
                  <td>$status_message</td>
                  <td>".count($cart)." Items</td>
                  <td>".$row['price']."</td>
                  <td>".$row['order_date']."</td>
                </tr>
              ";
            }
          }

          $conn -> close();
        ?>
      </tbody>
    </table>
  </section>

  <style>
    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      text-align: center;
      padding: 1rem;
      background-color: #000;
    }

    footer > p {
      margin: 0;
      color: #fff;
      font-weight: 500;
    }
  </style>

  <footer>
    <p style="font-size: 16px;">
      KOFEE MANILA
    </p>
  </footer>

  <script>
    

    $("#reviewForm").on("submit", function(event){
      event.preventDefault();

      let userid = $("#userid").val();
      let useremail = $("#useremail").val();
      let review = $("#review").val();
      let rating = $("#rating").val();

      $.ajax({
        type: 'post',
        url: 'api/post_feedback.php',
        data: {
          feedback : review,
          rating: rating,
        },
        success: response => {
          $('#reviewForm').modal("toggle")
        }
      })
    })

    $(".view-order-cell").on("click", function(){
      $.ajax({
        type: 'get',
        url: 'api/get_specific_order_details.php',
        data: {orderid: $(this).attr('data-target')},
        success: response => {
          $('#viewOrderModal').modal("show")
          $('#viewOrderModalBody').html(response)
        }
      })
    })
  </script>
</body>

</html>