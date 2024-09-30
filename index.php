<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KOFFEE MANILA</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Bootstrap CSS -->
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

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <style>


  </style>
</head>

<body>
  <!-- Navbar Section -->
  <?php include "includes/navbar.php"; ?>


  <!-- Image Background Cover Section -->
  <section class="bg-image">
    <div class="container text-center py-5">
      <div class="p-4 text-white">
        <!-- Content here -->
        <h1>Welcome to Koffee Manila</h1>
        <p>A cozy place to enjoy the finest coffee.</p>
      </div>
    </div>
  </section>

  <!-- Overview Section -->
  <section class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-6 align-self-center">
          <h2>Explore Our Coffee Selection</h2>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla
            quis lorem ut libero malesuada feugiat.
          </p>
        </div>
        <div class="col-md-6">
          <img src="assets/overview.png" class="img-fluid" alt="Coffee Cup" />
        </div>
      </div>
    </div>
  </section>


  <section class="bg-light text-center py-5">
    <div class="container">
      <h2>Our Best Sellers</h2>
      <hr class="w-50" />
      <div class="owl-carousel owl-theme">
        <div class="item">
          <img src="assets/items/1.png" alt="Product 1" />
          <h5>Latte</h5>
        </div>
        <div class="item">
          <img src="assets/items/2.png" alt="Product 2" />
          <h5>Cappuccino</h5>
        </div>
        <div class="item">
          <img src="assets/items/3.png" alt="Product 3" />
          <h5>Americano</h5>
        </div>
        <div class="item">
          <img src="assets/items/4.png" alt="Product 4" />
          <h5>Espresso</h5>
        </div>
      </div>
    </div>
  </section>

  <!-- White Background Section with Centered Image -->
  <section class="text-center py-5">
    <div class="container">
      <div class="image-container position-relative">
        <img src="assets/footer-index.png" class="img-fluid" alt="Coffee Beans" />
        <div class="image-text">
          WHERE EVERY SIP TELLS A STORY
        </div>
      </div>
    </div>
  </section>

  <?php include "includes/footer.php"; ?>



  <!-- Owl Carousel Initialization Script -->
  <script>
    $(document).ready(function () {
      $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 20,
        nav: true,
        responsive: {
          0: {
            items: 1,
          },
          600: {
            items: 2,
          },
          1000: {
            items: 4,
          },
        },
      });
    });

  </script>
</body>

</html>