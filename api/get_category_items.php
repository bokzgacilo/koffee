<?php
  include("connection.php");

  $categoryId = $_GET['category_id'];

  $getAll = "";

  if ($categoryId === "all") {
    $getAll = $conn->query("SELECT * FROM product_list WHERE status = 1");
} else {
    $getAll = $conn->query("SELECT * FROM product_list WHERE category_id = $categoryId AND status = 1");
}

if ($getAll->num_rows > 0) {
    // Fetch all rows into an array
    $products = [];

    while ($row = $getAll->fetch_assoc()) {
        $products[] = $row;
    }

    // Sort products by 'sold' count in descending order
    usort($products, function ($a, $b) {
        return $b['sold'] <=> $a['sold'];
    });

    // Get the top 3 sold products
    $topSoldProducts = array_slice($products, 0, 2);
    $topSoldIds = array_column($topSoldProducts, 'id');

    // Display products with "Best Seller" tag for the top 3
    foreach ($products as $row) {
        $trimmed_value = str_replace(['Small', 'Large'], '', $row['name']);
        $isBestSeller = in_array($row['id'], $topSoldIds) ? "🔥 Hot Picks" : "";

        echo "
        <div class='col-lg-3 col-6 menu-item'>";
        echo "
          <div class='custom-tag'>";
                    $givenTimestamp = strtotime($row['date_created']);
                    $currentTimestamp = time();

                    $threeDaysAgoTimestamp = strtotime('-7 days');

                    if($isBestSeller !== ""){
                      echo "<span class='is-best'>".$isBestSeller."</span>";

                    }

                    if ($givenTimestamp >= $threeDaysAgoTimestamp && $givenTimestamp <= $currentTimestamp) {
                      echo "<span class='is-new'>New</span>";
                    }

              echo "</div>
        ";
        
        echo "
            <img src='./" . $row['image_url'] . "' />
            <h3>" . $trimmed_value . "</h3>
            <p><strong>" . number_format($row['price'], 2) . "</strong></p>
            <a href='item.php?id=" . $row['id'] . "' class='col col-12 btn btn-primary btn-lg'>BUY</a>
        </div>
        ";
    }}


  $conn -> close();
?>