<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Cart - KOFFEE MANILA</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    />
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
    <!-- Bootstrap JS, Popper.js, and jQuery (Optional) -->
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
      /* Firefox Scrollbar Styles */
      html {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
      }
      body {
        font-family: "Montserrat", sans-serif; /* Apply Montserrat font to entire body */
      }
      .bg-image {
        background-image: url("assets/bg-contact.png");
        background-size: cover;
        background-position: center;
        height: 500px; /* Adjust as needed */
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
        <a class="navbar-brand" href="menu.php"><i class="fas fa-chevron-left"></i> BACK TO MENU</a>
    </nav>
    <!-- Image Background Cover Section -->
    <section >
      <div class="container">
        <div class="p-4 d-flex flex-column ">
          <h1>My Cart</h1>
          <p>Here's your cart.</p>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Size</th>
                <th scope="col">Addon</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total Price</th>
                <th scope="col">Instruction</th>
                <th scope="col">Action</th>
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
                    // print_r($product_row);
                    echo "
                      <tr>
                        <th>".$item['productName']."</th>
                        <th>".$item['size']."</th>
                        <th>".$item['addon']."</th>
                        <th>".$item['quantity']."</th>
                        <th>".$product_row['price']."</th>
                        <th>".$item['totalPrice']."</th>
                        <th>".$item['instructions']."</th>
                        <th>
                          <button class='btn btn-sm'>Remove</button>
                          <button class='btn btn-sm'>Edit</button>
                        </th>
                      </tr>
                    ";
    
                  }
    
                  $conn -> close();
    
                }
              ?>
            </tbody>
          </table>

          <div class="mt-4 mb-4">
            <p style="font-size: 18px;">Cart Price: PHP <?php echo number_format($total_price, 2); ?></p>
            <p style="font-size: 18px;">Delivery Fee: PHP <?php echo number_format($delivery_fee, 2); ?></p>
            <p style="font-size: 18px; font-weight: bold;" class="mt-4">Total Price: PHP <?php echo number_format($delivery_fee + $total_price, 2); ?></p>
          </div>
          <?php
            if(!$cart){
              echo "<button class='btn btn-primary' disabled  >Review Payment and Address</button>";

            }else {
              echo "<a href='review-payment-address.php' class='add-to-cart-btn'  >Review Payment and Address</a>";

            }
          ?>
        </div>
      </div>
    </section>


    <!-- Footer Section -->
      <?php include "includes/footer.php"; ?>
  </body>
</html>
