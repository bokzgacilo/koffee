<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KOFEE MANILA</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <!-- Bootstrap JS, Popper.js, and jQuery (Optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
</head>

<body>
  <!-- Navbar Section -->
  <?php include "includes/navbar.php"; ?>

  <!-- Image Background Cover Section -->
  <section class="bg-image">
    <div class="container text-center py-5">
      <div class="p-4 text-white">
        <h1>Welcome to Kofee Manila</h1>
        <p>A cozy place to enjoy the finest coffee.</p>
      </div>
    </div>
  </section>

  <!-- Orders Table Section -->
  <section class="container my-5">
    <h2 class="mb-4">Orders</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Status</th>
          <th>Order</th>
          <th>Price</th>
          <th>Order Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include("api/connection.php");

          $result = $conn -> query("SELECT * FROM orders WHERE client_id='".$_SESSION['userid']."'");
          if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
              $cart = json_decode($row['cart'], true);

              echo "
                <tr>
                  <td>".$row['id']."</td>
                  <td>".$row['status']."</td>
                  <td>".count($cart)." Items</td>
                  <td>".$row['price']."</td>
                  <td>".$row['order_date']."</td>
                </tr>
              ";
            }
          }

          $conn -> close();
        ?>
      </tbody>
    </table>
  </section>

  <?php include "includes/footer.php"; ?>

</body>

</html>