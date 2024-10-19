  <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us - KOFEE MANILA</title>
    <script src="libs/jquery.js"></script>
  <script src="libs/popper.js"></script>

  <script src="libs/bootstrap.min.js"></script>
  <link href="libs/bootstrap.min.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />

    <style>
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
      body {
        font-family: "Montserrat", sans-serif; /* Apply Montserrat font to entire body */
      }
      .bg-image {
        background-image: url("assets/bg-about.png");
        background-size: cover;
        background-position: center;
        height: 500px; /* Adjust as needed */
      }
    </style>
  </head>
  <body>
    <!-- Navbar Section -->
    <?php include "includes/navbar.php"; ?>

    <!-- Image Background Cover Section -->
    <section class="bg-image">
      <div class="container text-center py-5">
        <div class="text-white p-4">
          <h1>About Kofee Manila</h1>
          <p>Learn more about our story and what drives us.</p>
        </div>
      </div>
    </section>

    <!-- About Us Section -->
    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-6 align-self-center">
            <h2>Our Story</h2>
            <p>
              Kofee Manila was founded with a passion for great coffee and a
              desire to create a cozy space where people can come together and
              enjoy the finest brews. From our humble beginnings to becoming a
              beloved spot in the community, our journey has been fueled by a
              commitment to quality and a love for coffee culture.
            </p>
          </div>
          <div class="col-md-6">
            <img
              src="assets/story.png"
              class="img-fluid"
              alt="Our Story"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Footer Section -->
     <?php include "includes/footer.php"; ?>
  </body>
</html>
