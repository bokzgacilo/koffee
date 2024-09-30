<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - KOFFEE MANILA</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <!-- Bootstrap CSS -->
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <!-- Bootstrap JS, Popper.js, and jQuery (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.com/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        background-image: url("assets/bg-contact.png");
        background-size: cover;
        background-position: center;
        height: 500px; /* Adjust as needed */
      }
      .contact-info {
        padding: 2rem 0;
        background-color: #f8f9fa;
      }
      .contact-info h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
      }
      .contact-info p {
        margin-bottom: 0.5rem;
      }
      .contact-info .social-icons a {
        font-size: 1.5rem;
        color: #333;
        margin-right: 1rem;
        transition: color 0.3s ease;
      }
      .contact-info .social-icons a:hover {
        color: #6c757d;
      }
      .map-container {
        height: 800px; /* Increased height */
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
          <h1>Contact Us</h1>
          <p>We'd love to hear from you. Get in touch with us!</p>
        </div>
      </div>
    </section>

    <!-- Contact Information Section -->
    <section class="contact-info text-center">
      <div class="container">
        <h3>Get in Touch</h3>
        <p><i class="fas fa-phone-alt"></i> +63 912 345 6789</p>
        <p><i class="fas fa-envelope"></i> info@koffeemanila.com</p>
        <p>
          <i class="fas fa-map-marker-alt"></i> 123 Coffee St, Manila,
          Philippines
        </p>
        <div class="social-icons">
          <a href="https://facebook.com" target="_blank"
            ><i class="fab fa-facebook-f"></i
          ></a>
          <a href="https://twitter.com" target="_blank"
            ><i class="fab fa-twitter"></i
          ></a>
          <a href="https://instagram.com" target="_blank"
            ><i class="fab fa-instagram"></i
          ></a>
        </div>
      </div>
    </section>

    <!-- Google Map Section -->
    <section class="map-container">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3858.6782012135464!2d120.98201731537069!3d14.556732789826333!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c9f84d5d0e6d%3A0x9a9ec9e7c2b1a6b2!2s123%20Coffee%20St%2C%20Manila%2C%20Philippines!5e0!3m2!1sen!2sus!4v1614384341734!5m2!1sen!2sus"
        width="100%"
        height="100%"
        frameborder="0"
        style="border: 0"
        allowfullscreen=""
        aria-hidden="false"
        tabindex="0"
      >
      </iframe>
    </section>

    <!-- Footer Section -->
      <?php include "includes/footer.php"; ?>
  </body>
</html>
