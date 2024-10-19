<?php
  // Database connection (adjust credentials as needed)
  include("connection.php");
  // Query to fetch feedback data
  $sql = "SELECT * FROM customer_feedback"; // Assuming you have a table 'customer_feedback'
  $result = $conn -> query($sql);

  // Loop through the results and output the slides
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $averageRating = round($row['rating'], 1);
      echo "
      <div class='card'>
        <div class='card-body d-flex flex-column'>
          <h6 class='mb-4' style='font-weight: bold;'>".$row['feedback']."</h6>
          <div class='average-rating  mt-auto mb-2'>";
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $averageRating) {
                    echo "<span style='font-size: 24px; color: #e1be04cf;'>&#9733;</span>"; // filled star
                } else {
                    echo "<span style='font-size: 24px; color: #ccc;'>&#9733;</span>"; // empty star
                }
            }

            echo " </div>
          <p class='mt-auto'>".$row['customer_name']."</p>
        </div>
         
      </div>";
    }
  } else {
    echo "No feedback found!";
  }

  $conn->close();
?>