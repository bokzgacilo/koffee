<?php
require 'connection.php';

// Fetch the item ID from the request (e.g., GET parameter)
$item_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to 1 if not provided

// Fetch product details (assuming product names include size, e.g., "Americano Small" or "Americano Large")
$product_query = "SELECT * FROM product_list WHERE id = :id";
$product_stmt = $pdo->prepare($product_query);
$product_stmt->bindParam(':id', $item_id, PDO::PARAM_INT);
$product_stmt->execute();
$product = $product_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch large variation if available
$large_query = "SELECT * FROM product_list WHERE name LIKE CONCAT(:name, ' Large')";
$large_stmt = $pdo->prepare($large_query);
$small_name = str_replace(' Small', '', $product['name']); // Remove " Small" from the name
$large_stmt->bindParam(':name', $small_name, PDO::PARAM_STR);
$large_stmt->execute();
$large_product = $large_stmt->fetch(PDO::FETCH_ASSOC); // Large variation if it exists

// Fetch all addons with their prices
$addons_query = "SELECT * FROM addons";
$addons_stmt = $pdo->prepare($addons_query);
$addons_stmt->execute();
$addons = $addons_stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Item Details - KOFFEE MANILA</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <!-- Bootstrap JS, Popper.js, and jQuery (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.com/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>
    <!-- Navbar Section -->
    <?php include "includes/navbar.php"; ?>

    <nav class="navbar navbar-expand-lg navbar-custom">
      <a class="navbar-brand" href="menu.php"><i class="fas fa-chevron-left"></i> BACK TO MENU</a>
    </nav>
    <br>
    <!-- Item Details Section -->
    <div class="item-container">
        <div class="item-details">
            <div class="item-image">
                <!-- Display product image -->
                <img class="img-fluid" src="uploads/products/2022-04-22_10-18-15.png"
                    alt="<?php echo $product['name']; ?>" />
            </div>
            <div class="item-info">
                <input type="text" value="<?php echo htmlspecialchars($product['name']); ?>" id="productName" hidden />
                <div class="item-name"><?php echo htmlspecialchars($product['name']); ?></div>
                <div class="item-price">₱<span
                        id="productPrice"><?php echo number_format($product['price'], 2); ?></span></div>

                <!-- Quantity Selector -->
                <div class="quantity">
                    <span>Quantity:</span>
                    <input type="number" id="quantity" value="1" min="1" />
                </div>
            </div>
        </div>

        <!-- Other Information -->
        <div class="other-info">
            <h4>Item Details</h4>

            <!-- Variation (Size) Selector -->
            <div class="variation">
                <span>Size:</span>
                <div>
                    <label>
                        <input type="radio" name="size" value="small" checked data-price="<?php echo $product['price']; ?>" />
                        <span class="radio-circle"></span>
                        Small (₱<?php echo number_format($product['price'], 2); ?>)
                    </label>

                    <?php if ($large_product): ?>
                        <label>
                            <input type="radio" name="size" value="large"
                                data-price="<?php echo $large_product['price']; ?>" />
                            <span class="radio-circle"></span>
                            Large (₱<?php echo number_format($large_product['price'], 2); ?>)
                        </label>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Add-ons Section -->
            <div class="add-ons">
                <span>Add-ons:</span>
                <div>
                    <?php foreach ($addons as $addon): ?>
                        <label>
                            <input id="addon" type="radio" name="addon" value="<?php echo htmlspecialchars($addon['name']); ?>"
                                data-price="<?php echo $addon['price']; ?>" />
                            <span class="radio-circle"></span>
                            <?php echo htmlspecialchars($addon['name']); ?>
                            (₱<?php echo number_format($addon['price'], 2); ?>)
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Special Instructions -->
            <div class="special-instructions">
                <label for="instructions">Special Instructions:</label>
                <textarea id="instructions" rows="3" placeholder="Enter any special instructions here"></textarea>
            </div>
        </div>

        <!-- Add to Cart Button -->
         <?php
          if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
            echo "<button class='add-to-cart-btn' id='addToCartBtn'>Add to Cart</button>";
          }else {
            echo "<a href='login.php' class='add-to-cart-btn'>Sign In to Add Cart</a>";
          }
         ?>
        
    </div>
    <script>
      $(document).ready(function(){
        $("#addToCartBtn").on("click", function(){
          var quantity = $("#quantity").val();
          var instructions = $("#instructions").val();
          var productName = $("#productName").val();

          var size = $("input[name='size']:checked")
          var addon = $("input[name='addon']:checked")
          var add_price = 0;


          if(addon.val() === undefined){
            addon = "none";
          }else {
            addon = addon.val()
          }

          if(addon === "none"){
            add_price = 0;
          }else {
            add_price = $("input[name='addon']:checked").attr('data-price')
          }

          var totalPrice = (parseFloat(size.attr('data-price')) + parseFloat(add_price)) * quantity;
          
          var cart_item = {
            productName: productName,
            quantity: quantity,
            size: size.val(),
            addon : addon,
            instructions: instructions,
            totalPrice : totalPrice
          }

          $.ajax({
            url: 'api/update_cart.php',
            method: 'POST',
            data: JSON.stringify({
              userid : <?php echo $_SESSION['userid']; ?>,
              cart_item : cart_item
            }),
            contentType: "application/json",
            dataType: "json",
            success: function(response) {
              alert(response.message)
            },
          })
        })
      })
    </script>

    <?php include "includes/footer.php"; ?>
</body>

</html>