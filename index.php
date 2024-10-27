<?php
  include("api/connection.php");

  $c = $conn -> query("SELECT * FROM content_management WHERE id=1");
  $content = $c -> fetch_assoc();

  $conn -> close();
?>
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
        <?php
          $sliders = $slides = json_decode($content['banner'], true);
          foreach ($sliders as $index => $slider) {
            echo "<button type='button' data-bs-target='#banner-carousel' data-bs-slide-to='".$index."' class='active' aria-current='true' aria-label='Slide ".($index+1)."'></button>";
          }
        ?>
      </div>

      <div class="carousel-inner">
        <?php
          $slides = json_decode($content['banner'], true);

          foreach ($slides as $slide) {
            if($slide['id'] === 1){
              echo "
                <div class='carousel-item active'>
                  <img src='".$slide['image']."' class='d-block w-100'>
                  <div class='carousel-caption d-none d-md-block'>
                    <h1>".$slide['title']."</h1>
                    <p>".$slide['title']."</p>
                  </div>
                </div>
                ";
            }else {
              echo "
                <div class='carousel-item'>
                  <img src='".$slide['image']."' class='d-block w-100'>
                  <div class='carousel-caption d-none d-md-block'>
                    <h1>".$slide['title']."</h1>
                    <p>".$slide['title']."</p>
                  </div>
                </div>
                ";
            } 
          }
        ?>

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
        <?php
          $descriptions = json_decode($content['description'], true);

          foreach ($descriptions as $desc) {
            echo "
              <div class='col-md-6 align-self-center'>
                <h2>".$desc['title']."</h2>
                <p>".$desc['description']."</p>
              </div>
              <div class='col-md-6'>
                <img src='".$desc['image']."' class='img-fluid'/>
              </div>
            ";
          }
        ?>
      </div>
    </div>
  </section>

  <style>
    #feedbacks {
      display: grid;
      grid-template-columns: 1fr;
      gap: 0.5rem;
      padding: 1rem;
    }

    /* Media query for larger screens (e.g., desktops) */
    @media (min-width: 1024px) {
      #feedbacks {
        grid-template-columns: 1fr 1fr 1fr 1fr;
      }
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