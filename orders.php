<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KOFFEE MANILA</title>
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
        <h1>Welcome to Koffee Manila</h1>
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
          <th>Transaction ID</th>
          <th>Status</th>
          <th>Date</th>
          <th>Total</th>
          <th>Change</th>
          <th>Payment</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>TXN001234</td>
          <td>Completed</td>
          <td>2024-08-01</td>
          <td>₱500.00</td>
          <td>₱50.00</td>
          <td>Cash</td>
        </tr>
        <tr>
          <td>TXN001235</td>
          <td>Pending</td>
          <td>2024-08-02</td>
          <td>₱750.00</td>
          <td>₱0.00</td>
          <td>Credit Card</td>
        </tr>
        <tr>
          <td>TXN001236</td>
          <td>Cancelled</td>
          <td>2024-08-03</td>
          <td>₱300.00</td>
          <td>₱0.00</td>
          <td>Cash</td>
        </tr>
        <tr>
          <td>TXN001237</td>
          <td>Completed</td>
          <td>2024-08-04</td>
          <td>₱1,200.00</td>
          <td>₱200.00</td>
          <td>Bank Transfer</td>
        </tr>
      </tbody>
    </table>
  </section>

  <?php include "includes/footer.php"; ?>

</body>

</html>