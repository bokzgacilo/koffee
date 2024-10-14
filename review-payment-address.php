<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Review Payment And Address - KOFEE MANILA</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CSS -->
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.com/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
      ::-webkit-scrollbar {
        width: 8px;
      }
      ::-webkit-scrollbar-track {
        background: #f1f1f1;
      }
      ::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
      }
      ::-webkit-scrollbar-thumb:hover {
        background: #555;
      }

      html {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
      }
      body {
        font-family: "Montserrat", sans-serif;
      }
      .bg-image {
        background-image: url("assets/bg-contact.png");
        background-size: cover;
        background-position: center;
        height: 500px; 
      }
      .contact-info {
        padding: 2rem 0;
        background-color: #f8f9fa;
      }
      .contact-info h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
      }
      .contact-info p {
        margin-bottom: 0.5rem;
      }
      .contact-info .social-icons a {
        font-size: 1.5rem;
        color: #333;
        margin-right: 1rem;
        transition: color 0.3s ease;
      }
      .contact-info .social-icons a:hover {
        color: #6c757d;
      }
      .map-container {
        height: 800px; /* Increased height */
      }
    </style>
  </head>
  <body>
    <!-- Navbar Section -->
    <?php include "includes/navbar.php"; ?>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="cart.php"><i class="fas fa-chevron-left"></i> BACK TO CART</a>
    </nav>
    <!-- Image Background Cover Section -->
    <section >
      <div class="container">
        <div class="p-4">
          <h2>Review Payment And Address</h2>
          <div class="card mt-4">
            <div class="card-body">
            <h5 class="mb-4">Here's your order</h5>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Price</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $total_price = 0;
                $delivery_fee = 0;
                $cart = [];

                if(empty($row['cart']) || $row['cart'] === " "){
                  echo "<p class='mt-4' style='font-size: 24px; font-weight: bold;'>Your cart is empty!</p>";
                }else {
                  include("api/connection.php");

                  $delivery_fee += 50;
    
                  $sql = $conn -> prepare("SELECT cart FROM users WHERE id = ?");
                  $sql -> bind_param("i", $_SESSION['userid']);
                  $sql -> execute();

    
                  $result = $sql -> get_result();
                  $row = $result -> fetch_assoc();

                  $cart = $row['cart'];

                  foreach(json_decode($row['cart'], true) as $item){
                    $product = $conn -> prepare("SELECT * FROM product_list WHERE name = ?");
                    $product -> bind_param("s", $item['productName']);
                    $product -> execute();
                    $product_res = $product -> get_result();
                    $product_row = $product_res -> fetch_assoc();
                    $total_price += $item['totalPrice'];

                    echo "
                      <tr>
                        <th>".$item['productName']."</th>
                        <th>".$item['quantity']."</th>
                        <th>".$item['totalPrice']."</th>
                      </tr>
                    ";
    
                  }
    
                  $conn -> close();
    
                }
              ?>
            </tbody>
          </table>
          <div class="text-align-right">
            <p style="font-size: 18px; font-weight: bold;">Total Price: PHP <?php echo number_format($delivery_fee + $total_price, 2); ?> (Delivery fee included.)</p>
          </div>
          </div>
          </div>
                
          <div class="card mt-4">
            <div class="card-body">
              <h4 style="font-weight: bold;">STEP 1 : Scan the QR to Pay</h4>
              <div class="d-flex flex-row">
                <div class="col-6 d-flex flex-column">
                  <img style="width: 200px; height: 200px;" src="frame.png" />
                  <p>This is a sample QR only.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="card mt-4">
            <div class="card-body">
              <h4 style="font-weight: bold;">STEP 2 : Upload Receipt Here</h4>
              <div class="d-flex flex-row">
                <div class="col-6 mt-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Upload</label>
                    <input type="file" class="form-control" id="receipt_image">
                  </div>
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">Reference Number</label>
                    <input type="email" class="form-control" id="reference_number" aria-describedby="emailHelp">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card mt-4">
            <div class="card-body">
            <h4 style="font-weight: bold;">STEP 3 : Delivery Address</h4>
            <div class="d-flex flex-column">
                <div class="d-flex flex-row">
                <div class="col-4">
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">Contact Number 1</label>
                    <input type="email" class="form-control" id="contact_number1" aria-describedby="emailHelp">
                  </div>
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">Contact Number 2</label>
                    <input type="email" class="form-control" id="contact_number2" aria-describedby="emailHelp">
                  </div>
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">Street Name</label>
                    <input type="email" class="form-control" id="street_name" aria-describedby="emailHelp">
                  </div>
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">Barangay</label>
                    <input type="email" class="form-control" id="barangay" aria-describedby="emailHelp">
                  </div>
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">City</label>
                    <input type="email" class="form-control" id="city" aria-describedby="emailHelp">
                  </div>
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">Nearest LandMark</label>
                    <input type="email" class="form-control" id="nearest_landmark" aria-describedby="emailHelp">
                  </div>
                <button class="mt-4 btn btn-primary btn-lg" id="proceedOrderButton">Proceed Order</button>

                </div>
                <div class="col-8">
                  <div style="width: 100%"><iframe width="720" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=720&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=17&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.gps.ie/">gps tracker sport</a></iframe></div>
                </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    
    <script>
      $(document).ready(function(){
        var fileBase64;

        $("#receipt_image").on("change", function(){
          let file = this.files[0];

          if(file){
            var reader = new FileReader();

            reader.onload = function(event){
              var based64String = event.target.result;
              fileBase64 = based64String;
            }

            reader.readAsDataURL(file)
          }
        })

        $("#proceedOrderButton").on("click", function(){
          let cart = <?php echo $cart; ?>;
          let reference_number = $("#reference_number").val();
          // let gcash = $("#gcash").val();
          let contact_number1 = $("#contact_number1").val();
          let contact_number2 = $("#contact_number2").val();
          let street_name = $("#street_name").val();
          let barangay = $("#barangay").val();
          let city = $("#city").val();
          let nearest_landmark = $("#nearest_landmark").val();

          let address = `${street_name}, ${barangay}, ${city}`;

          console.log(fileBase64)

          $.ajax({
            type: "post",
            url: "api/make_order.php",
            data: {
              cart : cart,
              reference_number : reference_number,
              gcash : fileBase64,
              contact_number1 : contact_number1,
              contact_number2 : contact_number2,
              address : address,
              nearest_landmark : nearest_landmark,
              map : "test",
              price : <?php echo number_format($delivery_fee + $total_price, 2); ?>,
              client_id : <?php echo $_SESSION['userid']; ?>
            },
            success: (response) => {
              Swal.fire({
                title: "Order Submitted",
                text: "Thank you for ordering with us.",
                icon: "success",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: "Go To Orders",
                denyButtonText: `Don't save`
              }).then((result) => {
                if (result.isConfirmed) {
                  location.href="orders.php"
                }
              });
            }
          })
          console.log(address)
        })
      })
    </script>

    <!-- Footer Section -->
      <?php include "includes/footer.php"; ?>
  </body>
</html>
