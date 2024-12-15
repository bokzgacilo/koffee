<?php
  session_start();
?>

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
    </style>
  </head>
  <body>
    <!-- Navbar Section -->
    <?php include "includes/navbar.php"; ?>

    <style>
      .backtomenunav {
        background: rgb(213 140 30);
        position: sticky;
        top: 82px;
        padding: 0.5rem 12%;
        z-index: 9000;
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
          <h4 class="mt-4" style="font-weight: bold;">Review Payment And Address</h4>
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
          <hr />
          <h5 style="font-weight: bold;" class="mt-4">Estimated Time Order</h5>
          <div class="d-flex flex-row mt-4">
            <div class="col-12 col-lg-6 d-flex flex-column">
              <div style="font-size: 28px; gap: 1rem" class="d-flex flex-row align-items-center">
                <i class='fas fa-clock'></i>
                <h4 class="mb-0">10 - 15 Minutes</h4>
              </div>
             
            </div>
          </div>
          </div>
          </div>
          <form id="review-payment-form">
            <input type="hidden" name="cart" value=<?php echo $row['cart']; ?> />
            <input type="hidden" name="price" value="<?php echo $delivery_fee + $total_price; ?>" />
            <input type="hidden" name="client_id" value="<?php echo $_SESSION['userid']; ?>" />
          <div class="card mt-4">
            <div class="card-body">
              <h5 style="font-weight: bold;">STEP 1 : Scan the QR to Pay</h5>
              <div class="d-flex flex-row">
                <div class="col-12 col-lg-6 d-flex flex-column">
                  <?php
                    $gcash = json_decode($contact['gcash'], true);
                  ?>
                  <img class="img-fluid" style="width: 500px; height: auto;" src="<?php echo $gcash[0]['image']; ?>" />
                  <h4 class="mt-4"><?php echo $gcash[0]['name']; ?> - <?php echo $gcash[0]['number']; ?></h4>
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
                    <input type="file" accept="image/*" class="form-control" name="gcash" required>
                  </div>
                  <div class="mt-3">
                    <label for="exampleInputEmail1" class="form-label">Reference Number</label>
                    <input type="text" class="form-control" name="reference_number" required>
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
                    <input type="text" class="form-control" name="contact_number1" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div>
                    <label for="exampleInputEmail1" class="form-label">Contact Number 2</label>
                    <input type="text" class="form-control" name="contact_number2" required>
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
                    } ?>' placeholder="House 33" class="form-control" name="block_number" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">Street Name</label>
                    <input type="text" value='<?php if($address['street'] === "None"){
                      echo "";
                    }else {
                      echo $address['street'];
                    } ?>' class="form-control" placeholder="Yellow Bell" name="street_name" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">Barangay</label>
                    <select name="barangay" class="form-control">
                      <option value="Burol">Burol</option>
                      <option value="Burol I">Burol I</option>
                      <option value="Burol II">Burol II</option>
                      <option value="Burol III">Burol III</option>
                      <option value="Datu Esmael">Datu Esmael</option>
                      <option value="Emmanuel Bergado I">Emmanuel Bergado I</option>
                      <option value="Emmanuel Bergado II">Emmanuel Bergado II</option>
                      <option value="Fatima I">Fatima I</option>
                      <option value="Fatima II">Fatima II</option>
                      <option value="Fatima III">Fatima III</option>
                      <option value="H-2">H-2</option>
                      <option value="Langkaan I">Langkaan I</option>
                      <option value="Langkaan II">Langkaan II</option>
                      <option value="Luzviminda I">Luzviminda I</option>
                      <option value="Luzviminda II">Luzviminda II</option>
                      <option value="Paliparan I">Paliparan I</option>
                      <option value="Paliparan II">Paliparan II</option>
                      <option value="Paliparan III">Paliparan III</option>
                      <option value="Sabang">Sabang</option>
                      <option value="Saint Peter I">Saint Peter I</option>
                      <option value="Saint Peter II">Saint Peter II</option>
                      <option value="Salawag">Salawag</option>
                      <option value="Salitran I">Salitran I</option>
                      <option value="Salitran II">Salitran II</option>
                      <option value="Salitran III">Salitran III</option>
                      <option value="Salitran IV">Salitran IV</option>
                      <option value="Sampaloc I">Sampaloc I</option>
                      <option value="Sampaloc II">Sampaloc II</option>
                      <option value="Sampaloc III">Sampaloc III</option>
                      <option value="Sampaloc IV">Sampaloc IV</option>
                      <option value="Sampaloc V">Sampaloc V</option>
                      <option value="San Agustin I">San Agustin I</option>
                      <option value="San Agustin II">San Agustin II</option>
                      <option value="San Agustin III">San Agustin III</option>
                      <option value="San Andres I">San Andres I</option>
                      <option value="San Andres II">San Andres II</option>
                      <option value="San Antonio de Padua I">San Antonio de Padua I</option>
                      <option value="San Antonio de Padua II">San Antonio de Padua II</option>
                      <option value="San Dionisio">San Dionisio</option>
                      <option value="San Esteban">San Esteban</option>
                      <option value="San Francisco I">San Francisco I</option>
                      <option value="San Francisco II">San Francisco II</option>
                      <option value="San Isidro Labrador I">San Isidro Labrador I</option>
                      <option value="San Isidro Labrador II">San Isidro Labrador II</option>
                      <option value="San Jose">San Jose</option>
                      <option value="San Juan">San Juan</option>
                      <option value="San Lorenzo Ruiz I">San Lorenzo Ruiz I</option>
                      <option value="San Lorenzo Ruiz II">San Lorenzo Ruiz II</option>
                      <option value="San Luis I">San Luis I</option>
                      <option value="San Luis II">San Luis II</option>
                      <option value="San Manuel I">San Manuel I</option>
                      <option value="San Manuel II">San Manuel II</option>
                      <option value="San Mateo">San Mateo</option>
                      <option value="San Miguel I">San Miguel I</option>
                      <option value="San Miguel II">San Miguel II</option>
                      <option value="San Nicolas I">San Nicolas I</option>
                      <option value="San Nicolas II">San Nicolas II</option>
                      <option value="San Roque">San Roque</option>
                      <option value="San Simon">San Simon</option>
                      <option value="Santa Cristina I">Santa Cristina I</option>
                      <option value="Santa Cristina II">Santa Cristina II</option>
                      <option value="Santa Cruz I">Santa Cruz I</option>
                      <option value="Santa Cruz II">Santa Cruz II</option>
                      <option value="Santa Fe">Santa Fe</option>
                      <option value="Santa Lucia">Santa Lucia</option>
                      <option value="Santa Maria">Santa Maria</option>
                      <option value="Santo Cristo">Santo Cristo</option>
                      <option value="Santo Niño I">Santo Niño I</option>
                      <option value="Santo Niño II">Santo Niño II</option>
                      <option value="Sultan Esmael">Sultan Esmael</option>
                      <option value="Victoria Reyes">Victoria Reyes</option>
                      <option value="Zone I">Zone I</option>
                      <option value="Zone I-B">Zone I-B</option>
                      <option value="Zone II">Zone II</option>
                      <option value="Zone III">Zone III</option>
                      <option value="Zone IV">Zone IV</option>
                    </select>
                    <!-- <input type="text" value='<?php if($address['barangay'] === "None"){
                      echo "";
                    }else {
                      echo $address['barangay'];
                    } ?>' class="form-control" placeholder="Pembo" id="a_barangay" required> -->
                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">City</label>
                    <input type="text" readonly value='Dasmarinas' placeholder="Makati City" class="form-control" name="city" required>
                  </div>
                </div>
                <div class="col-12 col-lg-4">
                  <div>
                    <label class="form-label">Nearest LandMark</label>
                    <input type="text" class="form-control" name="nearest_landmark" placeholder="Dasma Bayan" required>
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
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15462.886174801963!2d120.9352866!3d14.3276005!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d54bd9893d23%3A0xc66dd3f6e762b5ba!2sKofee%20Manila%20-%20Dasma%20Bayan!5e0!3m2!1sen!2sph!4v1731424160842!5m2!1sen!2sph">
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
        let nearest_barangay = $("#a_barangay").val();

        let landmark = `${nearest_landmark}, ${nearest_barangay}, Dasmarinas Cavite`

        var googleMapsUrl = "https://www.google.com/maps/embed/v1/place?key=AIzaSyAitbCyHS9bbWyT3BoPoFlPKa-fwwEpG7c&q=" + encodeURIComponent(landmark);
        $('#googleMap').attr('src', googleMapsUrl);
      })

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

        $("#review-payment-form").on("submit", function(event){
          event.preventDefault();

          var formdata = new FormData(this);

          $.ajax({
            type: "post",
            url: "api/make_order.php",
            contentType: false,
            processData: false, 
            data: formdata,
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
