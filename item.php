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
      <a class="navbar-brand" href="menu.php"><i class="fas fa-chevron-left"></i> BACK TO MENU</a>
    </nav>

    <style>
      .item-container {
        padding: 1rem;
        display: grid;
        grid-template-columns: 0.5fr 1fr 0.5fr;
        gap: 2rem;
        justify-content: center;
      }

      .product-body {
        padding: 2rem;
      }

      @media (max-width: 768px) {
        .item-container {
          grid-template-columns: 1fr;
        }

        .product-body {
          padding: 2rem;
        }
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
    </style>

    <main class="item-container p-4">
      <div class="col">
        <img class="img-fluid w-100" style="height: 400px; object-fit: contain;" src="./<?php echo $product['image_url']; ?>" />
        <!-- <h5 style="font-weight: bold;" class="mt-4">Price Breakdown</h5>
          <div class="row">
            <div class="col-5">
              <p>Size Price:</p>
            </div>
            <div class="col-7">
              <p class="size-price"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-5">
              <p>Addon Price:</p>
            </div>
            <div class="col-7">
              <p class="addon-price"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-5">
              <p>Per Item Price:</p>
            </div>
            <div class="col-7">
              <p class="peritem-price"></p>
            </div>
          </div>
          <span style="font-size: 14px; font-weight: bold;">Formula: (size price + addon price) * quantity</span> -->
      </div>
      <div class="col card">
        <div class="card-body product-body">
        <input type="text" value="<?php echo htmlspecialchars($product['name']); ?>" id="productName" hidden />
        <h1 style="font-weight: bold;"><?php echo $product['name']; ?></h1>
        <h1 class="item-price mt-4">₱ <span id="productPrice"><?php echo number_format($product['price'], 2); ?></span></h1>
        
        <p class="mt-4" style="font-weight: bold;">QUANTITY</p>
        <div class="quantity">
          <span id="decButton">-</span>
          <h2 id="newQuantity">1</h2>
          <input type="number" id="quantity" value="1" min="1" max="100" step="1" hidden/>
          <span id="incButton">+</span>
        </div>

        <?php
          if($product['size_price'] !== ""){
            $sizes = json_decode($product['size_price'], true);
            echo "<p class='mt-4' style='font-weight: bold;'>SIZE</p><div class='row'>";

            
            foreach ($sizes as $size) {
              $ischecked = "";

              if($size['size'] === "small"){
                $ischecked = "checked";
              }else {
                if($size['size'] === "regular"){
                  $ischecked = "checked";
                }
              }

              echo "
                <div class='form-check col-12 col-lg-4 mb-lg-4'>
                  <input class='form-check-input' value='".$size['size']."' type='radio' name='size'  data-price='".number_format($size['price'], 2)."' $ischecked>
                  <label class='form-check-label'>
                    ".$size['size']." (₱".$size['price'].")
                  </label>
                </div>
              ";
            }
            echo "</div>";
          }else {
            echo "<input type='radio' name='size' data-price='".number_format($product['price'], 2)."' checked hidden>";
          }
        ?>

        <p style="font-weight: bold;">ADDONS</p>
        <div class="row">
          <?php foreach ($addons as $addon): ?>
            <div class="form-check col-12 col-lg-4 mb-4">
              <input class="form-check-input" name="addon" type="checkbox" data-price="<?php echo number_format($addon['price'], 2); ?>" data-name="<?php echo $addon['name']; ?>" />
              <label class="form-check-label"><?php echo $addon['name']; ?> (₱ <?php echo number_format($addon['price'], 2); ?>)</label>
            </div>
          <?php endforeach; ?>
        </div>
        <p class="mt-4">Special Instructions</p>

        <div class="form-floating mb-4">
          <textarea class="form-control" placeholder="Leave instruction here" id="instructions" style="height: 100px"></textarea>
        </div>

        <?php
          if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
            echo "<button class='btn btn-lg' style='background-color: #D68C1E; color: #fff;' id='addToCartBtn'>Add to Cart</button>";
          }else {
            echo "<a href='login.php' class='btn btn-lg btn-primary'>Sign In to Add Cart</a>";
          }
        ?>
        </div>
        
      </div>
         
        
        <div class="col card">
          <div class="card-body">
          <h4 class="mb-4" style="text-align: center; font-weight: bold;">You may also like</h4>
            <div class="row">
            <?php
              include("api/connection.php");
              $catId = $product['category_id'];
              $recommendations = $conn -> query("SELECT * FROM product_list WHERE category_id=$catId LIMIT 4");

              if($recommendations -> num_rows > 0){
                while($row = $recommendations -> fetch_assoc()){
                  if($product['name'] != $row['name']){
                    echo "
                      <div class='d-flex flex-column align-items-center col-lg-12 col-6'>
                        <img src='./".$row['image_url']."' class='img-fluid' style='height: 100px; object-fit: cover;' />
                        <a href='item.php?id=".$row['id']."' class='mt-2' style='font-weight: bold; font-size: 16px; text-align-center'>".$row['name']."</a>
                        <p class='mt-auto'>".number_format($row['price'], 2)." PHP</p>
                      </div>
                    ";
                  }
                }
              }

              $conn -> close();
            ?>
            </div>
          </div>
        </div>
    </main>
    </div>
    <script>
      var addTotal = 0;
      var addNames = "";
      var total_quantity = 1;
      var minValue = parseInt($('#quantity').attr('min'));
      var maxValue = parseInt($('#quantity').attr('max'));
      
      var addon_total_price = 0;
      var size_total_price = 0;
      var stotal = <?php echo $product['price']; ?>;

      function computePrice(original_price, quantity, addon_total, size_total){
        $('.base-price').text(parseFloat(stotal * quantity))
        $('.size-price').text(parseFloat(size_total * quantity))
        $('.addon-price').text(parseFloat(addon_total_price * quantity))
        $('.peritem-price').text(parseFloat((original_price + addon_total + size_total)))

        console.log("Base Price: " + stotal)
        console.log("Total Size Price: " + size_total)
        console.log("Total Addon Price: " + addon_total)
        console.log("Total Computed Price: " + (original_price + addon_total + size_total) * quantity)

        return (size_total + (addTotal * quantity));
      }

      $(document).ready(function(){
        let rating = parseFloat($("input[name='size']:checked").attr('data-price'));
        size_total_price = rating;
        $("#productPrice").text(parseFloat(computePrice(stotal, total_quantity, addon_total_price, size_total_price)).toFixed(2))

        console.log(size_total_price)
        var size_total = $("input[name='size']:checked").attr('data-price');
        var size_name = $("input[name='size']:checked").attr('data-name');

        $("#decButton").on("click", function(){
          let quantity = parseInt($('#quantity').val());

          if (quantity > minValue) {
            $('#newQuantity').text(quantity - 1);
            $('#quantity').val(quantity - 1);

            total_quantity = quantity - 1;
          }

          $("#productPrice").text(parseFloat(computePrice(stotal, total_quantity, addon_total_price, size_total_price)).toFixed(2))
        })

        $("#incButton").on("click", function(){
          let quantity = parseInt($('#quantity').val());

          if (quantity < maxValue) {
            $('#newQuantity').text(quantity + 1);
            $('#quantity').val(quantity + 1);

            total_quantity = quantity + 1;
          }

          $("#productPrice").text(parseFloat(computePrice(stotal, total_quantity, addon_total_price, size_total_price)).toFixed(2))
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

          var addon_price = parseFloat(total);
          addon_total_price = addon_price;

          $("#productPrice").text(parseFloat(computePrice(stotal, total_quantity, addon_total_price, size_total_price)).toFixed(2))
        })

        $("input[name='size']").on("change", function(){
          var size = $("input[name='size']:checked").attr('data-price');

          var total_size = parseFloat(size);
          size_total_price = total_size;

          $("#productPrice").text(parseFloat(computePrice(stotal, total_quantity, addon_total_price, size_total_price)).toFixed(2))
        })

        $("#quantity").on("change", function(){
          $("#productPrice").text(parseFloat(computePrice(stotal, total_quantity, addon_total_price, size_total_price)).toFixed(2))
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

          var cart_item = {
            productName: productName,
            quantity: quantity,
            size: size.val(),
            addon : addNames,
            instructions: instructions,
            totalPrice : computePrice(stotal, total_quantity, addon_total_price, size_total_price).toFixed(2)
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

  <?php include("includes/footer.php"); ?>
</body>

</html>