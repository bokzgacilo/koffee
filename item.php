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
$productID = $product['category_id'];
$addons_query = "SELECT * FROM addons WHERE category_id=$productID";
$addons_stmt = $pdo->prepare($addons_query);
$addons_stmt->execute();
$addons = $addons_stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Item Details - KOFEE MANILA</title>
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

    <style>
      .item-container {
        padding: 1rem;
        display: flex;
        flex-direction: row;
        gap: 2rem;
        justify-content: center;
      }

      .item-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }

      .quantity {
        display: flex;
        flex-direction: row;
        gap: 2rem;
        align-items: center;
      }

      .quantity > button, .quantity > input {
        padding: 1rem;
      }

      .quantity > h2 {
        margin: 0;
      }

      .quantity > span {
        cursor: pointer;
        display: grid;
        place-items: center;
        width: 40px;
        height: 40px;
        border: none;
        outline: none;
        background-color: #000;
        color: #fff;
      }

      .addons {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
      }
    </style>

    <main class="item-container">
      <div>
        <img style="width: 400px; height: 400px; object-fit: cover;" src="uploads/products/2022-04-22_10-18-15.png" />
      </div>
      <div>
        <div>
          <input type="text" value="<?php echo htmlspecialchars($product['name']); ?>" id="productName" hidden />
          <h2><?php echo $product['name']; ?></h2>
          <h1 class="item-price">₱ <span id="productPrice"><?php echo number_format($product['price'], 2); ?></span></h1>
          <p class="mt-4">Quantity</p>
          <div class="quantity">
            <span id="decButton">-</span>
            <h2 id="newQuantity">1</h2>
            <input type="number" id="quantity" value="1" min="1" max="100" step="1" hidden/>
            <span id="incButton">+</span>
          </div>
          <p class="mt-4">Size</p>
          <div>
            <div class="form-check">
              <input class="form-check-input" value="Small" type="radio" name="size" data-price="<?php echo number_format($product['price'], 2); ?>" checked>
              <label class="form-check-label" for="flexRadioDefault1">
                Small (₱<?php echo number_format($product['price'], 2); ?>)
              </label>
            </div>

            <?php if ($large_product): ?>
              <div class="form-check">
                <input class="form-check-input" value="Large" type="radio" name="size" data-price="<?php echo number_format($large_product['price'], 2); ?>">
                <label class="form-check-label" for="flexRadioDefault1">
                  Large (₱<?php echo number_format($large_product['price'], 2); ?>)
                </label>
              </div>
            <?php endif; ?>
          </div>
            <p class="mt-4">Add-ons</p>
            <div class="addons">
              <?php foreach ($addons as $addon): ?>
                <div class="form-check">
                  <input class="form-check-input" name="addon" type="checkbox" data-price="<?php echo number_format($addon['price'], 2); ?>" data-name="<?php echo $addon['name']; ?>" />
                  <label class="form-check-label"><?php echo $addon['name']; ?> (₱ <?php echo number_format($addon['price'], 2); ?>)</label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <p class="mt-4">Special Instructions</p>
          <div class="form-floating mb-4">
            <textarea class="form-control" placeholder="Leave instruction here" id="instructions" style="height: 100px"></textarea>
          </div>
          <?php
            if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
              echo "<button class='btn btn-lg btn-primary' id='addToCartBtn'>Add to Cart</button>";
            }else {
              echo "<a href='login.php' class='btn btn-lg btn-primary'>Sign In to Add Cart</a>";
            }
          ?>
      </div>
    </main>
    </div>
    <script>
      var addTotal = 0;
      var addNames = "";
      var total_quantity = 1;
      var minValue = parseInt($('#quantity').attr('min'));
      var maxValue = parseInt($('#quantity').attr('max'));


      $(document).ready(function(){
        var size_total = $("input[name='size']:checked").attr('data-price');
        var size_name = $("input[name='size']:checked").attr('data-name');

        $("#decButton").on("click", function(){
          let quantity = parseInt($('#quantity').val());

          if (quantity > minValue) {
            $('#newQuantity').text(quantity - 1);
            $('#quantity').val(quantity - 1);

            var totalPrice = parseFloat(addTotal) + (parseFloat(quantity - 1) * parseFloat(size_total));
            $("#productPrice").text(parseFloat(totalPrice).toFixed(2))
          }
        })

        $("#incButton").on("click", function(){
          var quantity = parseInt($('#quantity').val());

          if (quantity < maxValue) {
            $('#newQuantity').text(quantity + 1);
            $('#quantity').val(quantity + 1);

            var totalPrice = parseFloat(addTotal) + (parseFloat(quantity + 1) * parseFloat(size_total));
            $("#productPrice").text(parseFloat(totalPrice).toFixed(2))
          }
        })

        $("input[name='addon']").on("change", function(){
          let selectedAddons = [];
          let total = 0;
          let quantity = $('#quantity').val();

          $("input[name='addon']:checked").each(function(){
            let addonName = $(this).attr('data-name');
            let addonPrice = parseInt($(this).attr('data-price'));

            selectedAddons.push(addonName);
            total += addonPrice
          })

          addNames = selectedAddons.join(', ');
          addTotal = total;
          var totalPrice = (parseFloat(total) * quantity) + (parseFloat(quantity) * parseFloat(size_total));
          $("#productPrice").text(parseFloat(totalPrice).toFixed(2))
        })

        $("input[name='size']").on("change", function(){
          var size = $("input[name='size']:checked").attr('data-price');

          size_total = size;
          var totalPrice = addTotal + (parseInt($("#quantity").val()) * parseInt(size));
          $("#productPrice").text(parseFloat(totalPrice).toFixed(2))
        })

        $("#quantity").on("change", function(){
          var size = $("input[name='size']:checked").attr('data-price');

          var totalPrice = parseFloat(addTotal) + parseFloat($("#quantity").val()) * parseFloat(size_total);

          $("#productPrice").text(parseFloat(totalPrice).toFixed(2))
        })

        $("#addToCartBtn").on("click", function(){
          var quantity = $("#quantity").val();
          var instructions = $("#instructions").val();
          var productName = $("#productName").val();

          var size = $("input[name='size']:checked");
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

          var totalPrice = parseFloat(addTotal) + parseFloat($("#quantity").val()) * parseFloat(size_total);
          
          var cart_item = {
            productName: productName,
            quantity: quantity,
            size: size.val(),
            addon : addNames,
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