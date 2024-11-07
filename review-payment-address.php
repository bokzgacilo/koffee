<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Review Payment And Address - KOFEE MANILA</title>
    <script src="libs/jquery.js"></script>
    <script src="libs/popper.js"></script>

    <script src="libs/bootstrap.min.js"></script>
    <link href="libs/bootstrap.min.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
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

      .image-container {
          width: auto;
          height: auto;
          overflow: hidden;
      }

      .image-container img {
          transition: transform 0.5s ease;
      }
    </style>
  </head>
  <body>
    <!-- Navbar Section -->
    <?php include "includes/navbar.php"; ?>

    <style>
      .backtomenunav {
        padding: 0.5rem 12%;
      }

      @media (max-width: 768px) {
        .backtomenunav {
          padding: 0.5rem;
        }
      }
    </style>

    <nav class="navbar navbar-expand-lg navbar-custom backtomenunav">
        <a class="navbar-brand" href="cart.php"><i class="fas fa-chevron-left"></i> BACK TO CART</a>
    </nav>
    <!-- Image Background Cover Section -->
    <section >
      <div class="container">
        <div class="p-1 p-lg-4">
          <h4 class="mt-4">Review Payment And Address</h4>
          <div class="card mt-4">
            <div class="card-body">
            <h5 class="mb-4">Here's your order</h5>
            <div class="table-responsive">
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

                      $getcontact = $conn -> query("SELECT * FROM content_management WHERE id=1");
                      $contact = $getcontact -> fetch_assoc();

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
                    }
                  ?>
                </tbody>
              </table>
            </div>
            
          <div class="text-align-right">
            <p style="font-size: 16px; font-weight: bold;">Total Price: PHP <?php echo number_format($delivery_fee + $total_price, 2); ?> (Delivery fee included.)</p>
          </div>
          </div>
          </div>
          <form id="review-payment-form">

          <div class="card mt-4">
            <div class="card-body">
              <h5 style="font-weight: bold;">STEP 1 : Scan the QR to Pay</h5>
              <div class="d-flex flex-row">
                <div class="col-12 col-lg-6 d-flex flex-column">
                  <div class="image-container mb-4">
                      <img id="image"  src="<?php echo $contact['gcash']; ?>" alt="Sample Image" class="img-fluid">
                  </div>
                  <div class="controls">
                      <button type="button" id="zoomIn" class="btn btn-primary me-2">Zoom In</button>
                      <button type="button" id="zoomOut" class="btn btn-secondary">Zoom Out</button>
                  </div>
                  <!-- <img class="img-fluid" style="width: 500px; height: auto;" src="<?php echo $contact['gcash']; ?>" /> -->
                </div>
              </div>
            </div>
          </div>
          <div class="card mt-4">
            <div class="card-body">
              <h5 style="font-weight: bold;">STEP 2 : Upload Receipt Here</h5>
              <div class="d-flex flex-row">
                <div class="col-12 col-lg-6  mt-4">
                  <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Upload</label>
                    <input type="file" class="form-control" id="receipt_image" required>
                  </div>
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">Reference Number</label>
                    <input type="text" class="form-control" id="reference_number" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card mt-4">
            <div class="card-body">
            <h4 style="font-weight: bold;">STEP 3 : Delivery Address</h4>
            <div class="d-flex flex-column">
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <div>
                    <label for="exampleInputEmail1" class="form-label">Contact Number 1</label>
                    <input type="text" class="form-control" id="contact_number1" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div>
                    <label for="exampleInputEmail1" class="form-label">Contact Number 2</label>
                    <input type="text" class="form-control" id="contact_number2" required>
                  </div>
                </div>
              </div>

              <!-- Get Address Details -->
              <?php 
                $getAddress = $conn -> query("SELECT * FROM users WHERE id=".$_SESSION['userid']."");
                $address = $getAddress -> fetch_assoc();
              ?>

              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">Block/House/Unit Number</label>
                    <input type="text" value='<?php if($address['block_number'] === "None"){
                      echo "";
                    }else {
                      echo $address['block_number'];
                    } ?>' placeholder="House 33" class="form-control" id="a_block_number" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">Street Name</label>
                    <input type="text" value='<?php if($address['street'] === "None"){
                      echo "";
                    }else {
                      echo $address['street'];
                    } ?>' class="form-control" placeholder="Yellow Bell" id="street_name" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">Barangay</label>
                    <input type="text" value='<?php if($address['barangay'] === "None"){
                      echo "";
                    }else {
                      echo $address['barangay'];
                    } ?>' class="form-control" placeholder="Pembo" id="a_barangay" required>
                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">City</label>
                    <input type="text" value='<?php if($address['city'] === "None"){
                      echo "";
                    }else {
                      echo $address['city'];
                    } ?>' placeholder="Makati City" class="form-control" id="a_city" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">Nearest LandMark</label>
                    <input type="text" class="form-control" id="nearest_landmark" placeholder="TGP Pembo Makati" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4 d-flex align-items-end">
                  <div>
                  <button class="btn btn-primary" type="button" id="searchPin">Locate Address</button>

                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-8">
                  <iframe
                    id="googleMap"
                    width="100%"
                    height="450"
                    style="border:0"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAitbCyHS9bbWyT3BoPoFlPKa-fwwEpG7c&q=STI Dasmarinas">
                  </iframe>
                </div>
                
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <button class="btn btn-success" type="submit">Proceed Order</button>
                </div>
              </div>
                </div>
              </div>
            </div>
          </form>

          </div>
          
        </div>
      </div>
    </section>
    
    <script type="module" >
      import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
      import { getFirestore, collection, doc, setDoc, onSnapshot } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";

      const firebaseConfig = {
        apiKey: "AIzaSyDjWfyGpv_ECHnkHABYEss7J0unCrLH0ok",
        authDomain: "kofee-manila.firebaseapp.com",
        databaseURL: "https://kofee-manila-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "kofee-manila",
        storageBucket: "kofee-manila.appspot.com",
        messagingSenderId: "296750304629",
        appId: "1:296750304629:web:39d6e2d377dfff5984d73c"
      };

      // Initialize Firebase
      const app = initializeApp(firebaseConfig);

      // Add a new document to the logs collection

      async function firestoreSave(id) {
        const db = getFirestore(app);

        const user_updates_collection = "user_updates";

        const data = {
          message: "entry",
          orderid: id,
          userid: "<?php echo $_SESSION['userid']; ?>"
        };

        await setDoc(doc(db, user_updates_collection, id), data);
      }

      $("#searchPin").on('click', function(){
        let nearest_landmark = $("#nearest_landmark").val();
        var googleMapsUrl = "https://www.google.com/maps/embed/v1/place?key=AIzaSyAitbCyHS9bbWyT3BoPoFlPKa-fwwEpG7c&q=" + encodeURIComponent(nearest_landmark);
        $('#googleMap').attr('src', googleMapsUrl);
      })

      $(document).ready(function(){
        let scale = 1;
        const scaleStep = 0.5;
        var fileBase64;


        $('#zoomIn').click(function () {
            scale += scaleStep;
            $('#image').css('transform', `scale(${scale})`);
        });

        $('#zoomOut').click(function () {
            if (scale > scaleStep) {
                scale -= scaleStep;
                $('#image').css('transform', `scale(${scale})`);
            }
        });


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

        $("#review-payment-form").on("submit", function(event){
          event.preventDefault();
          let cart = <?php echo $cart; ?>;
          let reference_number = $("#reference_number").val();
          let contact_number1 = $("#contact_number1").val();
          let contact_number2 = $("#contact_number2").val();
          let block_number = $("#a_block_number").val();
          let street_name = $("#street_name").val();
          let barangay = $("#a_barangay").val();
          let city = $("#a_city").val();
          let nearest_landmark = $("#nearest_landmark").val();

          let address = `${block_number}, ${street_name}, ${barangay}, ${city}`;
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
              map : nearest_landmark,
              price : parseFloat(<?php echo $delivery_fee + $total_price; ?>).toFixed(2),
              client_id : <?php echo $_SESSION['userid']; ?>
            },
            success: (response) => {
              firestoreSave(response)
              
              setTimeout(() => {
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
              }, 5000);
            }
          })
        })
      })
    </script>

    <!-- Footer Section -->
      <?php include "includes/footer.php"; ?>
  </body>
</html>
