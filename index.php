<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KOFEE MANILA</title>
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

    .carousel-item > img {
      width: 100%;
      height: 900px;
      object-fit: cover;
    }

    .carousel-caption {
      background: #000;
    }

    .carousel-caption > p, h1 {
      margin: 0;
    }
  </style>

  <section>
    <div id="banner-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators" style="margin-bottom: 0;">
        <button type="button" data-bs-target="#banner-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#banner-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#banner-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <!-- First Slide -->
        <div class="carousel-item active">
          <img src="uploads/stock/stock (1).jpg" class="d-block w-100" alt="First Slide">
          <div class="carousel-caption d-none d-md-block">
            <h1>Welcome to Kofee Manila</h1>
            <p>A cozy place to enjoy the finest coffee.</p>
          </div>
        </div>
        
        <!-- Second Slide -->
        <div class="carousel-item">
          <img src="uploads/stock/stock (2).jpg" class="d-block w-100" alt="Second Slide">
          <div class="carousel-caption d-none d-md-block">
            <h1>Second Slide</h1>
            <p>Description for the second slide.</p>
          </div>
        </div>
        
        <!-- Third Slide -->
        <div class="carousel-item">
          <img src="uploads/stock/stock (3).jpg" class="d-block w-100" alt="Third Slide">
          <div class="carousel-caption d-none d-md-block">
            <h1>Third Slide</h1>
            <p>Description for the third slide.</p>
          </div>
        </div>
      </div>

      <!-- Left and right controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#banner-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#banner-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
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
      <!-- Carousel -->
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

  <style>
    #feedbacks {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      gap: 0.5rem;
      padding: 1rem;
    }
  </style>

  <section class="bg-light text-center py-5">
    <h2>Customers Feedback</h2>
    <div id="feedbacks">
      
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

  <script>
    $(document).ready(function(){

      $.ajax({
        type: 'get',
        url: "api/get_all_feedbacks.php",
        success: response => {
          $('#feedbacks').html(response)
        }
      })
    })
  </script>
</body>

</html>