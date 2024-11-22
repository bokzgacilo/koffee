
<?php
  include("api/connection.php");

  $getcontact = $conn -> query("SELECT * FROM content_management WHERE id=1");
  $contact = $getcontact -> fetch_assoc();
  
  $abouts = json_decode($contact['about'], true);

  $conn -> close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FAQ - KOFEE MANILA</title>
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

    <!-- About Us Section -->
    <section class="py-5">
      <div class="container">
        <h4 class="fw-bold text-center">Frequently Asked Question</h4>
        <div class="accordion accordion-flush mt-4" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-1" aria-expanded="false" aria-controls="flush-1">
                <strong>What are your Best-Sellers?</strong>
              </button>
            </h2>
            <div id="flush-1" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                Our best-sellers include: <br><br>
                Iced Coffee: Caramel, Dark Choco<br>
                Milk Tea: Dark Choco, Mango Cheesecake, Okinawa<br>
                Frappe (Cream Based): Choco Chip, Strawberry<br>
                Frappe (Coffee Based): Coffee Vanilla Caramel, Java Chip<br>
                Fruit Tea: Lychee<br>
                Hot Drinks: Kofee Macchiato<br>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-2" aria-expanded="false" aria-controls="flush-2">
                <strong>What are your hours of operation?</strong>
              </button>
            </h2>
            <div id="flush-2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">-	We are open 7AM o 10PM, Weekdays.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-3" aria-expanded="false" aria-controls="flush-3">
                <strong>Can I customize my drink?</strong>
              </button>
            </h2>
            <div id="flush-3" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">Absolutely! You can customize your drink with sweetness level and add-ons such as cream cheese, pearl, coffee jelly, crushed oreos etc. Just let us know your preferences when you place your order.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-4" aria-expanded="false" aria-controls="flush-4">
                <strong>Where is your shop are located? </strong>
              </button>
            </h2>
            <div id="flush-4" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">005 Don Placido Campos Ave., Zone 1, Dasmariñas, Philippines, you can see it by clicking (*Clickable "About us"). </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-5" aria-expanded="false" aria-controls="flush-5">
                <strong>Is there a problem with your order?</strong>
              </button>
            </h2>
            <div id="flush-5" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">If there is a problem with your order, you can contact Kofee Manila Dasmariñas by using customer service.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-6" aria-expanded="false" aria-controls="flush-6">
                <strong>Who Are We?</strong>
              </button>
            </h2>
            <div id="flush-6" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">Welcome to Kofee Manila, your go-to destination for exceptional coffee experiences in the heart of the city. We are a passionate group of coffee enthusiasts dedicated to bringing you the finest coffee, expertly brewed to perfection. Our mission is to create a welcoming space where coffee lovers can gather and enjoy high-quality beverages and snacks.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-7" aria-expanded="false" aria-controls="flush-7">
                <strong>What Makes Us Special?</strong>
              </button>
            </h2>
            <div id="flush-7" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">Our commitment to quality and community sets Kofee Manila apart from other coffee shops. We ensure that every cup you enjoy supports ethical practices and delivers unmatched flavor. Our skilled baristas craft each drink with care, making every visit a delightful experience.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-8" aria-expanded="false" aria-controls="flush-8">
                <strong>Why Choose Kofee Manila? </strong>
              </button>
            </h2>
            <div id="flush-8" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">At Koffee Manila, we believe that coffee is more than just a drink—its a way to connect, unwind, and inspire. We specialize in refreshing cold drinks, perfect for cooling down in the tropical climate. Additionally, we offer a delicious selection of snacks, including nachos and pastries, to complement your coffee experience.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-9" aria-expanded="false" aria-controls="flush-9">
                <strong>What Can You Expect From Us?</strong>
              </button>
            </h2>
            <div id="flush-9" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">When you step into Koffee Manila, you can expect a cozy ambiance, friendly staff, and a memorable experience. Enjoy our wide range of cold coffee blends, tasty snacks, and a space that feels like home.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-10" aria-expanded="false" aria-controls="flush-10">
                <strong>How Can You Join Our Community?</strong>
              </button>
            </h2>
            <div id="flush-10" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">It’s easy to be a part of the Koffee Manila community! Visit us at our shop, follow us on social media, and engage with us through our events and special promotions. We can’t wait to share our love for coffee with you.</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer Section -->
     <?php include "includes/footer.php"; ?>
  </body>
</html>
