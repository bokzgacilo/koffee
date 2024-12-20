<?php
  session_start();
  include_once("connection.php");

  // Fetch categories
  $query = "SELECT id, name FROM category_list WHERE status = 1 AND delete_flag = 0";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Fetch products
  $query = "SELECT * FROM product_list WHERE status = 1";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Sort products by 'sold' count in descending order
  usort($products, function ($a, $b) {
    return $b['sold'] <=> $a['sold'];
  });

  // Get the top 3 sold counts
  $topSoldProducts = array_slice($products, 0, 3);
  $topSoldIds = array_column($topSoldProducts, 'id');

  // Add the "Best Seller" tag
  foreach ($products as &$product) {
    $product['tag'] = in_array($product['id'], $topSoldIds) ? "Best Seller" : "";
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - KOFEE MANILA</title>
    <script src="libs/jquery.js"></script>
    <script src="libs/popper.js"></script>

    <script src="libs/bootstrap.min.js"></script>
    <link href="libs/bootstrap.min.css" rel="stylesheet" />
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap JS, Popper.js, and jQuery (Optional) -->
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .custom-tag {
          position: absolute;
          top: 0;
          right: 0;
          font-size: 12px;
          font-weight: 500;
          display: flex;
          flex-direction: row;
          gap: 0.5rem;
        }

        .is-new, .is-best {
          color: #fff;
          padding: 0.25rem 1rem;
          border-radius: 5px;
        }

        .is-new {
          background-color: red;
        }

        .is-best {
          background-color: #d68c1e;
        }

        .category-menu {
          background-color: #d68c1e;
          color: white;
          text-align: center;
          justify-content: center;
          display: flex;
          overflow-x: auto;
          white-space: nowrap;
          position: sticky;
          top: 82px;
          z-index: 5000;
        }

        @media (max-width: 768px) {
          .category-menu {
            display: none;
          }

          .category-menu + .for-mobile {
            display: flex;
          }
        }

        .category-menu span {
          cursor: pointer;
          padding: 1rem;
          white-space: nowrap;
          transition: 0.15s;
        }

        .category-menu span:hover {
          text-decoration: none;
          background-color: #9f6815;
        }

        .selected-category-container {
            display: flex;
            align-items: center;
            margin: 2rem 0;
        }

        .selected-category {
            font-size: 1.5rem;
            padding-left: 1rem;
        }

        .selected-category-line {
            flex-grow: 1;
            height: 2px;
            background-color: black;
            margin-left: 1rem;
        }

        .menu-item {
          position: relative;
          padding: 0.5rem;
          display: flex;
          flex-direction: column;
          text-align: center;
        }

        .menu-item img {
          width: 100%;
          max-width: 100%;
          height: 275px;
          object-fit: contain;
          margin-bottom: 0.5rem;
        }

        .menu-item > a {
          margin-top: auto;
          background-color: #d68c1e !important;
          border: none;
          outline: none;
        }

        /* Scrollbar Styles */
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

        .for-mobile {
          display: none;
        }
    </style>
    <script>
        function displayCategory(categoryId) {
          let menutitle = $(`#category-${categoryId}`).attr('data-title')

          if(menutitle === undefined){
            menutitle = "ALL MENU"
          }

          $.ajax({
            type: "get",
            url: "api/get_category_items.php",
            data: {
              category_id : categoryId
            },
            success: response => {
              $("#menu-title").html(menutitle)
              $("#menu-items").html(response)
            }
          })
        }

        $(document).on("change", "#for-mobile-changer", function(){
          displayCategory($("#for-mobile-changer").val())
        })
    </script>
</head>

<body>
    <!-- Navbar Section -->
    <?php include "includes/navbar.php"; ?>

    <!-- Category Menu -->
    <div class="category-menu">
      <span onclick="displayCategory('all')">ALL MENU</span>
      <?php foreach ($categories as $category): ?>
          <span id="category-<?php echo $category['id']; ?>" onclick="displayCategory('<?php echo $category['id']; ?>')" data-title="<?php echo strtoupper($category['name']); ?>">
            <?php echo strtoupper($category['name']); ?>
          </span>
      <?php endforeach; ?>
    </div>

    <div class="category-menu for-mobile p-2">
      <select class="form-control" id="for-mobile-changer">
        <option value="all">ALL MENU</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?php echo $category['id'];?>"><?php echo $category['name']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    
    <style>
     
    </style>
    <!-- Selected Category and Menu Items -->
    <div class="container">
      <h1 class="mt-4 mb-4" id="menu-title">All Menu</h1>
      <div class="row menu-items" id="menu-items">
        <?php foreach ($products as $product): ?>
            <div class="col-lg-3 col-6 menu-item">
              <div class="custom-tag">
                <?php 
                    $givenTimestamp = strtotime($product['date_created']);
                    $currentTimestamp = time();

                    $threeDaysAgoTimestamp = strtotime('-7 days');

                    if($product['tag'] !== ""){
                      echo "<span class='is-best'>".$product['tag']."</span>";

                    }

                    if ($givenTimestamp >= $threeDaysAgoTimestamp && $givenTimestamp <= $currentTimestamp) {
                      echo "<span class='is-new'>New</span>";
                    }

                ?>
              </div>
            
              <img src="./<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" />

              <?php
              $productName = $product['name'];
              $cleanedProductName = preg_replace('/\bsmall\b/i', '', $productName);
              $cleanedProductName = trim($cleanedProductName);
              ?>

              <h3><?php echo htmlspecialchars($cleanedProductName, ENT_QUOTES, 'UTF-8'); ?></h3>
              <p><strong><?php echo number_format($product['price'], 2); ?></strong></p>
              <a href="item.php?id=<?php echo $product['id']; ?>" class="col col-12 btn btn-primary btn-lg mt-auto">BUY</a>
            </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php include('includes/footer.php'); ?>
</body>

</html>