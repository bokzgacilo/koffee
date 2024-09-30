<?php
session_start();

$row = [];

if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
  include("api/connection.php");

  $sql = $conn -> prepare("SELECT * FROM users WHERE id = ?");
  $sql -> bind_param("i", $_SESSION['userid']);
  $sql -> execute();

  $result = $sql -> get_result();
  $row = $result -> fetch_assoc();

  $conn -> close();
}
?>

<body>
  <style>
    body {
      font-family: "Montserrat", sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .item-container {
      background-color: white;
      padding: 2rem;
      margin: 2rem auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      max-width: 800px;
    }

    .item-details {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 1.5rem;
    }

    .item-image img {
      width: 100%;
      max-width: 400px;
      border-radius: 10px;
      border: 2px solid black;
    }

    .item-info {
      text-align: center;
    }

    .item-name {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    .item-price {
      font-size: 1.5rem;
      margin-bottom: 1rem;
    }

    .quantity {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 1rem;
    }

    .quantity input {
      width: 50px;
      text-align: center;
      margin: 0 0.5rem;
      border: 1px solid #ced4da;
      border-radius: 5px;
      padding: 5px;
    }

    .add-to-cart-btn {
      background-color: #d68c1e;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .add-to-cart-btn:hover {
      background-color: #c76c1b;
    }

    .other-info {
      padding: 2rem;
      border-radius: 10px;
      margin-top: 1rem;
    }

    .variation,
    .sweetness-level,
    .add-ons,
    .special-instructions {
      margin-bottom: 1rem;
    }

    .variation label,
    .sweetness-level label,
    .add-ons label {
      margin-right: 0.5rem;
      cursor: pointer;
    }

    .variation input[type="radio"],
    .sweetness-level input[type="radio"],
    .add-ons input[type="radio"] {
      display: none;
    }

    .radio-circle {
      width: 30px;
      height: 30px;
      background: white;
      border-radius: 50%;
      border: 1px solid #d68c1e;
      display: inline-block;
      margin-right: 0.5rem;
      position: relative;
      top: 10px;
      transition: background 0.3s;
    }

    .variation input[type="radio"]:checked+.radio-circle,
    .sweetness-level input[type="radio"]:checked+.radio-circle,
    .add-ons input[type="radio"]:checked+.radio-circle {
      background: #d68c1e;
    }

    .special-instructions textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ced4da;
      border-radius: 5px;
    }

    .footer {
      background-color: #6c757d;
      color: white;
      text-align: center;
      padding: 1rem;
      margin-top: auto;
    }

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

    .navbar-custom {
      background: rgba(213, 140, 30, 0.81);
      box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    }

    .navbar-custom .navbar-brand {
      color: white;
      font-size: 20px;
      font-family: Montserrat, sans-serif;
      font-weight: 700;
      letter-spacing: 2px;
      display: flex;
      align-items: center;
    }

    .navbar-custom .navbar-brand i {
      margin-right: 10px;
    }

    .bg-d68c1e {
      background-color: #d68c1e;
    }

    .navbar-light .navbar-nav .nav-link {
      color: black;
    }

    .nav-link {
      padding: 2px 5px 2px 5px !important;

    }

    .nav-item.join-now {
      border: solid 1px #D68C1E;
      border-radius: 50px;
    }

    .nav-item.join-now .nav-link {
      color: #D68C1E !important;
    }

    .navcontainer {
      font-weight: bold;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);

    }

    .item {
      width: 245px;
      /* Ensure each item container has the same width */
      height: 320px;
      /* Ensure each item container has the same height */
      text-align: center;
      /* Center align text */
    }

    .item img {
      width: 100%;
      /* Ensure each image fills its container */
      height: 100%;
      /* Ensure each image fills its container */
      max-width: 245px;
      /* Limit maximum width to 245px */
      max-height: 320px;
      /* Limit maximum height to 320px */
      display: block;
      /* Prevent any extra space around the image */
      margin: 0 auto;
      /* Center the image within its container */
    }

    .item h5 {
      margin-top: 10px;
      /* Adjust spacing between image and text */
      font-size: 16px;
      /* Example font size */
    }

    .image-container {
      position: relative;
    }

    .navbar-nav .nav-item {
      margin-right: 20px;
      /* Adjust the right margin between nav items */
    }

    .navbar-nav .nav-link {
      padding: 10px 15px;
      /* Adjust the padding inside each nav link */
    }


    .image-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 54px;
      font-weight: bold;
      color: white;
      text-align: center;
      width: 100%;
      /* Ensure text is centered even if it wraps */
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      /* Optional: Add shadow for better contrast */
    }

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

    .form-control:focus {
      border: solid gray;
      outline: none !important;
      box-shadow: none !important;
      /* Remove box-shadow on focus */
    }

    .input-group-text {
      border: none !important;
    }

    body {
      font-family: "Montserrat", sans-serif;
      /* Apply Montserrat font to entire body */
    }

    .bg-image {
      background-image: url("assets/bg-main.png");
      background-size: cover;
      background-position: center;
      height: 500px;
      /* Adjust as needed */
    }

    .carousel-item img {
      max-height: 200px;
      /* Adjust image height as needed */
    }

    footer {
      background-color: #6c757d;
      color: white;
      text-align: center;
      padding: 1rem;
    }

    .text-white {
      color: white;
    }

    .D68C1E {
      color: #D68C1E;
    }

    .bg-D68C1E {
      border: none;
      background-color: #D68C1E;
      border-radius: 50px;
    }

    .bg-D68C1E:hover {
      border: none;
      background-color: #D68C1E;
      border-radius: 50px;
    }

    input[type=text],
    input[type=email],
    input[type=password],
    input[type=number],
    /* Include any other input types you might have */
    textarea {
      border: 2px solid #000;
      /* Black border */
      border-radius: 50px;
      /* Rounded corners */
      padding: 10px;
      /* Padding for better spacing */
      width: 100%;
      /* Full width by default */
      box-sizing: border-box;
      /* Include padding and border in element's total width and height */
    }

    /* Cart Icon */
    .cart-icon {
      cursor: pointer;
    }

    /* Drawer */
    .cart-drawer {
      position: fixed;
      top: 0;
      right: 0;
      width: 300px;
      height: 100%;
      background-color: #fff;
      box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
      transform: translateX(100%);
      transition: transform 0.3s ease-in-out;
      overflow-y: auto;
      z-index: 1000;
    }

    .drawer-header {
      padding: 1rem;
      background-color: #d68c1e;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .drawer-body {
      padding: 1rem;
    }

    .drawer-footer {
      padding: 1rem;
      background-color: #f8f9fa;
      text-align: center;
    }

    .close-drawer {
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
    }

    /* Overlay */
    .drawer-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      z-index: 999;
    }

    .cart-item {
      display: flex;
      margin-bottom: 1rem;
    }

    .cart-item img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 5px;
      margin-right: 1rem;
    }

    .cart-item-info {
      display: flex;
      flex-direction: column;
    }

    .modal-backdrop {
      z-index: 0 !important;
    }
  </style>

  <!-- Edit Profile Modal -->
  <div class="modal" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileLabel">Edit Profile</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
          <form id="editProfileForm" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="firstname" class="form-label">First Name</label>
              <input type="text" class="form-control" id="firstname" name="firstname"
                value="<?php echo $row['firstname'] ?>">
            </div>
            <div class="mb-3">
              <label for="lastname" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lastname" name="lastname"
                value="<?php echo $row['lastname']; ?>">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email"
                value="<?php echo $row['username']; ?>">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password"
                value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>">
            </div>
            <div class="mb-3">
              <label for="avatar" class="form-label">Avatar</label>
              <!-- Display current avatar if exists -->
              <?php if (isset($row['avatar'])): ?>
                <div>
                  <img src="path/to/avatar/<?php echo $row['avatar']; ?>" alt="Avatar" width="100">
                </div>
              <?php endif; ?>
              <!-- Input for new avatar -->
              <input type="file" class="form-control" id="avatar" name="avatar">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="saveChanges" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Include jQuery (full version) -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Include Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#saveChanges').click(function (e) {
        e.preventDefault(); // Prevent the form from submitting via the browser

        var formData = new FormData($('#editProfileForm')[0]); // Get the form data including file upload

        $.ajax({
          url: 'edit.php', // The PHP script that handles the form submission
          type: 'POST',
          data: formData,
          contentType: false,  // Necessary for file upload
          processData: false,  // Necessary for file upload
          success: function (response) {
            // Handle success - reload page or update UI accordingly
            alert("Profile updated successfully!");
            // console.log(response)
            location.reload();
          },
          error: function (xhr, status, error) {
            // Handle error
            alert("An error occurred: " + error);
          }
        });
      });
    });
  </script>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container navcontainer">
      <a class="navbar-brand" href="index.php">KOFFEE MANILA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <style>
            /* Add this to your CSS file */
            .navbar-nav {
              display: flex;
              align-items: center;
              /* Center items vertically */
            }

            .nav-item {
              display: flex;
              align-items: center;
              /* Center items vertically within each nav-item */
            }
          </style>
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
          <!-- Bootstrap CSS -->
          <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

          <!-- Bootstrap JavaScript -->
          <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

          <?php if (isset($_SESSION['userid'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <!-- Profile image -->
                <img
                  src="<?php echo !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : 'dist/img/no-image-available.png'; ?>"
                  alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px;">

              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li>
                  <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit
                    Profile</a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="orders.php">Orders</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>

              </ul>
            </li>
          <?php endif; ?>

          <?php if (!isset($_SESSION['userid'])): ?>
            <li class="nav-item" style="border: solid;border-width: 1px; border-radius:50px;">
              <a class="nav-link" href="login.php">Sign In</a>
            </li>
            <li class="nav-item join-now">
              <a class="nav-link" href="register.php">Join Now</a>
            </li>
          <?php endif; ?>
        </ul>
        <a class="cart-icon" href="cart.php">
          <i class="fas fa-shopping-cart"></i>
          <!-- <span class="badge badge-light" id="cart-count">0</span> -->
        </a>
      </div>
    </div>
  </nav>

  <!-- Drawer for Cart -->
  <div id="cart-drawer" class="cart-drawer">
    <div class="drawer-header">
      <h5>Your Cart</h5>
      <button class="close-drawer" onclick="toggleDrawer()">&times;</button>
    </div>
    <div id="cart-items" class="drawer-body">
      <!-- Cart items will be dynamically added here -->
    </div>
    <div class="drawer-footer">
      <p id="cart-total">Total: <strong>0.00</strong></p>
      <a href="checkout.php" class="btn bg-d68c1e">Checkout</a>

    </div>
  </div>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* Basic styling for modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      /* Limit the width */
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    /* Styling for cart items */
    .cart-item {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      display: block;
    }

    .cart-item p {
      margin: 5px 0;
    }

    .cart-buttons {
      margin-top: 10px;
    }

    .divider {
      border-top: 1px solid #ddd;
      margin: 10px 0;
    }
  </style>

  <!-- Modal HTML -->
  <div id="itemModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Item Details</h2>
      <div id="itemDetails"></div>
    </div>
  </div>

  <div id="cart-items"></div>
  <div id="cart-total"></div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const itemModal = document.getElementById('itemModal');
      const itemDetails = document.getElementById('itemDetails');
      const closeModal = document.querySelector('.close');

      // Function to display cart items
      function displayCartItems() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = ''; // Clear existing items

        if (cart.length > 0) {
          cart.forEach((item, index) => {
            // Create item container in a block/column format
            let itemDiv = document.createElement('div');
            itemDiv.classList.add('cart-item');
            itemDiv.innerHTML = `
              <p><strong>Name:</strong> ${item.name}</p>
              <p><strong>Price:</strong> ${item.price}</p>
              <div class="cart-buttons">
                <button class="btn btn-info view-item" data-index="${index}">View Item</button>
                <button class="btn btn-danger remove-item" data-index="${index}">Remove</button>
              </div>
              <div class="divider"></div>
          `;
            cartItemsContainer.appendChild(itemDiv);
          });

          // Update total
          let total = cart.reduce((sum, item) => sum + parseFloat(item.price) * item.quantity, 0);
          document.getElementById('cart-total').innerHTML = `Total: <strong>${total.toFixed(2)}</strong>`;
        } else {
          cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
          document.getElementById('cart-total').innerHTML = 'Total: <strong>0.00</strong>';
        }
      }

      // Function to handle item removal
      function removeCartItem(index) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        displayCartItems();
      }

      // Function to handle viewing item details
      function viewCartItem(index) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let item = cart[index];
        itemDetails.innerHTML = `
        <p><strong>Size:</strong> ${item.size}</p>
        <p><strong>Add-on:</strong> ${item.addon}</p>
        <p><strong>Instructions:</strong> ${item.instructions}</p>
        <p><strong>Price:</strong> ${item.price}</p>
        <p><strong>Quantity:</strong> ${item.quantity}</p>
      `;
        itemModal.style.display = 'block';
      }

      // Event listener for remove buttons
      document.getElementById('cart-items').addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-item')) {
          let index = event.target.getAttribute('data-index');
          removeCartItem(index);
        }
        if (event.target.classList.contains('view-item')) {
          let index = event.target.getAttribute('data-index');
          viewCartItem(index);
        }
      });

      // Event listener for close button in modal
      closeModal.addEventListener('click', () => {
        itemModal.style.display = 'none';
      });

      // Close modal if clicked outside of it
      window.addEventListener('click', (event) => {
        if (event.target === itemModal) {
          itemModal.style.display = 'none';
        }
      });

      // Refresh cart items every second
      setInterval(displayCartItems, 1000);

      // Initial display
      displayCartItems();
    });
  </script>


  <div id="drawer-overlay" class="drawer-overlay" onclick="toggleDrawer()"></div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="lc.js"></script>


  <script>
    function toggleDrawer() {
      var drawer = document.getElementById('cart-drawer');
      var overlay = document.getElementById('drawer-overlay');
      if (drawer.style.transform === 'translateX(0%)') {
        drawer.style.transform = 'translateX(100%)';
        overlay.style.display = 'none';
      } else {
        drawer.style.transform = 'translateX(0%)';
        overlay.style.display = 'block';
      }
    }

  </script>
</body>

</html>