<?php
require 'connection.php';

// Fetch categories
$query = "SELECT id, name FROM category_list WHERE status = 1 AND delete_flag = 0";
$stmt = $pdo->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch products
$query = "SELECT * FROM product_list WHERE status = 1 AND delete_flag = 0 AND name NOT LIKE '%large%'";
$stmt = $pdo->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        .category-menu {
            background-color: #d68c1e;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .category-menu span {
            cursor: pointer;
            margin: 0 1rem;
        }

        .category-menu span:hover {
            text-decoration: underline;
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

        .menu-items .menu-item {
            margin-bottom: 2rem;
            text-align: center;
        }

        .menu-item img {
            width: 100%;
            max-width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }

        .menu-item > a {
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
    </style>
    <script>
        function displayCategory(categoryId) {
          $.ajax({
            type: "get",
            url: "api/get_category_items.php",
            data: {
              category_id : categoryId
            },
            success: response => {
              $("#menu-items").html(response)
            }
          })
        }
    </script>
</head>

<body>
    <!-- Navbar Section -->
    <?php include "includes/navbar.php"; ?>

    <!-- Category Menu -->
    <div class="category-menu">
        <span onclick="displayCategory('all')">ALL MENU</span>
        <?php foreach ($categories as $category): ?>
            <span id="category-<?php echo $category['id']; ?>" onclick="displayCategory('<?php echo $category['id']; ?>')">
                <?php echo strtoupper($category['name']); ?>
            </span>
        <?php endforeach; ?>
    </div>

    <!-- Selected Category and Menu Items -->
    <div class="container">
        <h1 class="mt-4 mb-4">All Menu</h1>
        <div class="row menu-items" id="menu-items">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-item" data-category-id="<?php echo $product['category_id']; ?>">
                        <?php
                        $dateCreated = $product['date_created']; // Original format
                        $formattedDate = str_replace(':', '-', $dateCreated); // Replace colons with dashes
                    
                        $formattedDate = str_replace(' ', '_', $formattedDate); // Replace space with underscore
                        $formattedDate = str_replace('.png', '', $formattedDate); // Remove .png if necessary
                    
                        ?>

                        <img src="uploads/products/2022-04-22_10-18-15.png" alt="<?php echo $product['name']; ?>" /> <?php
                        $productName = $product['name'];

                        $cleanedProductName = preg_replace('/\bsmall\b/i', '', $productName);

                        // Trim any extra spaces left after removal
                        $cleanedProductName = trim($cleanedProductName);
                        ?>

                        <h3><?php echo htmlspecialchars($cleanedProductName, ENT_QUOTES, 'UTF-8'); ?></h3>

                        <p><strong><?php echo number_format($product['price'], 2); ?></strong></p>
                        <a href="item.php?id=<?php echo $product['id']; ?>"
                            class="col col-12 btn btn-primary btn-lg ">BUY</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
</body>

</html>