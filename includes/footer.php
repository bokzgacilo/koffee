<?php
  include("api/connection.php");

  $getcontact = $conn -> query("SELECT * FROM content_management WHERE id=1");
  $contact = $getcontact -> fetch_assoc();

  $conn -> close();
?>

<style>
  footer {
    bottom: 0;
    width: 100%;
    text-align: center;
    padding: 1rem;
    background-color: #000;
  }

  footer > p {
    margin: 0;
    color: #fff;
    font-size: 100px;
    font-weight: 1000;
  }
</style>

<footer>
  <p style="font-size: 20px;">
    KOFEE MANILA
  </p>
</footer>

<footer class="footer"> 
    <div class="footer-container">
        <!-- Column 1: About the Company -->
        <div class="footer-column">
            <h4>Kofee Manila</h4>
            <p>We are a coffee shop that provides a variety of coffee-based and tea-based beverages. Enjoy quality drinks at your convenience.</p>
        </div>

        <!-- Column 2: Useful Links -->
        <div class="footer-column">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="login.php">Terms & Conditions</a></li>
            </ul>
        </div>

        <!-- Column 3: Contact Information -->
        <div class="footer-column">
            <h4>Contact Us</h4>
            <p><i class="fas fa-map-marker-alt"></i> <?php echo $contact['address']; ?></p>
            <p><i class="fas fa-phone"></i> <?php echo $contact['phone']; ?></p>
            <p><i class="fas fa-envelope"></i> <?php echo $contact['email']; ?></p>
        </div>

        <!-- Column 4: Follow Us (Social Media) -->
        <div class="footer-column">
            <h4>Follow Us</h4>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> Koffee. All rights reserved.</p>
    </div>
</footer>

<style>
  /* Footer Styling */
.footer {
    background-color: black;
    color: #fff;
    padding: 40px 0;
    text-align: center;
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    max-width: 1200px;
    margin: 0 auto;
}

.footer-column {
    flex-basis: 23%;
    margin-bottom: 20px;
}

.footer-column h4 {
    font-size: 18px;
    margin-bottom: 15px;
    text-transform: uppercase;
    color: #f1c40f;
}

.footer-column p, .footer-column ul, .footer-column li {
    margin: 5px 0;
    font-size: 14px;
    color: #ddd;
}

.footer-column ul {
    list-style: none;
    padding: 0;
}

.footer-column ul li {
    margin: 5px 0;
}

.footer-column ul li a {
    color: #ddd;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-column ul li a:hover {
    color: #f1c40f;
}

.footer-bottom {
    margin-top: 20px;
    font-size: 14px;
    color: #bbb;
}

.social-icons {
    margin-top: 15px;
}

.social-icons a {
    color: #ddd;
    font-size: 18px;
    margin: 0 10px;
    transition: color 0.3s ease;
}

.social-icons a:hover {
    color: #f1c40f;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
    }

    .footer-column {
        flex-basis: 100%;
        margin-bottom: 30px;
    }
}

</style>