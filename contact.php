<?php
  include("api/connection.php");

  $getcontact = $conn -> query("SELECT * FROM content_management WHERE id=1");
  $contact = $getcontact -> fetch_assoc();

  $conn -> close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - KOFEE MANILA</title>
    <script src="libs/jquery.js"></script>
    <script src="libs/popper.js"></script>
    <script src="libs/bootstrap.min.js"></script>
    <link href="libs/bootstrap.min.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />

    <style>
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

      /* Main Styles */
      body {
        font-family: "Montserrat", sans-serif;
      }

      /* Background Image Section */
      .bg-image {
        background-image: url("./assets/Brown Modern Coffee Presentation.webp");
        /* Backup background color in case image doesn't load */
        background-color: #d3b8ae;
        background-size: cover;
        background-position: center;
        height: 500px;
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
        height: 800px;
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
    <style>
      .messageus {
        width: 500px;
      }

      @media (max-width: 768px) {
        .messageus {
          width: 100%;
        }
      }

      #messageusform {
        display: flex;
        flex-direction: column;
        gap: 1rem;
      }
    </style>
    <section class="container d-flex flex-column align-items-center mt-4 mb-4">
        <h3>Message Us</h3>
        <div class='messageus mt-4'>
          <form id="messageusform">
            <label>Name</label>
            <input name="messagename" class="form-control" type="text" required/>
            <label>Email</label>
            <input name="messageemail" class="form-control" type="text" required/>
            <label>Message</label>
            <textarea name="messagebody" class="form-control" required></textarea>
            <button type="submit" class="btn btn-primary">Send Message</button>
          </form>
        </div>
    </section>
    <!-- Contact Information Section -->
    <section class="contact-info text-center">
      <div class="container">
        <h3>Get in Touch</h3>
        <p><i class="fas fa-phone-alt"></i> <?php echo $contact['phone']; ?></p>
        <p><i class="fas fa-envelope"></i> <?php echo $contact['email']; ?></p>
        <p>
          <i class="fas fa-map-marker-alt"></i> <?php echo $contact['address']; ?>
        </p>
        <div class="social-icons">
          <a href="https://www.facebook.com/kofeemnldasma" target="_blank"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
          <a href="https://www.tiktok.com/@kofeemaniladasmabayan"><i class="fab fa-tiktok"></i></a>
          <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </section>

    <!-- Google Map Section -->
    <section class="map-container">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d710.1983347081095!2d120.93496048102882!3d14.327519625920248!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d54bd9893d23%3A0xc66dd3f6e762b5ba!2sKofee%20Manila%20-%20Dasma%20Bayan!5e0!3m2!1sen!2sph!4v1730113623157!5m2!1sen!2sph"
        width="100%"
        height="100%"
        frameborder="0"
        style="border: 0"
        allowfullscreen=""
        aria-hidden="false"
        tabindex="0"
      ></iframe>
    </section>

    <!-- Footer Section -->
    <?php include "includes/footer.php"; ?>
    <script>
      $(document).ready(function(){
        $("#messageusform").on("submit", function(e){
          e.preventDefault();
          
          var formdata = {
            name : $("input[name='messagename']").val(),
            email : $("input[name='messageemail']").val(),
            body : $("textarea[name='messagebody']").val(),
          }

          $.ajax({
            type: 'post',
            url: 'api/send_message_us.php',
            data: formdata,
            success: response => {
              if(response === "ok"){
                alert("Message Submitted")
                location.reload()
              }
            }
          })
        })
      })

      
    </script>
  </body>
</html>
