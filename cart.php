<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Cart - KOFEE MANILA</title>
    <script src="libs/jquery.js"></script>
    <script src="libs/popper.js"></script>

    <script src="libs/bootstrap.min.js"></script>
    <link href="libs/bootstrap.min.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />

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
                    $product_name = $item['productName'];

                    echo "
                      <tr>
                        <th>".$item['productName']."</th>
                        <th>".$item['size']."</th>
                        <th>".$item['addon']."</th>
                        <th>".$item['quantity']."</th>
                        <th>".$product_row['price']."</th>
                        <th>".$item['totalPrice']."</th>
                        <th>".$item['instructions']."</th>
                        <th><button data-target='".$product_name."' class='removeButton btn btn-sm btn-danger'>Remove</button>
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

          <div>
            <?php
              if(!$cart){
                echo "<button class='btn btn-lg btn-primary' disabled>Review Payment and Address</button>";

              }else {
                echo "<a style='background-color: rgba(213, 140, 30); color: #fff;' href='review-payment-address.php' class='btn btn-lg'>Review Payment and Address</a>";

              }
            ?>
          </div>
        
        </div>
      </div>
    </section>
    <script>
      $(document).ready(function(){
        $(".removeButton").click(function(){
          var button = $(this);
          Swal.fire({
            title: "Remove this item from cart?",
            text: "You won't be able to revert this!",
            icon: "warning",
            confirmButtonText: "Yes, remove it!"
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                type: 'post',
                url: 'api/remove_item_from_cart.php',
                data: {
                  item : button.attr('data-target')
                },
                success : response => {
                  Swal.fire({
                    title: "Removed!",
                    text: "Item removed from cart.",
                    icon: "success"
                  });
                  
                  location.reload();
                }
              })
            }
          });

          
        })
      })
    </script>
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
  </body>
</html>
