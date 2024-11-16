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

    .sign-in {
      border-radius: 20px;
      background-color: #000;
      color: #fff !important;

}

    .join-now {
      border-radius: 20px;
      background-color: #D68C1E;
      color: #fff !important;
  
    }

    .navcontainer {
      font-weight: bold;
    }

    .item {
      width: 245px;
      height: 320px;
      text-align: center;
    }

    .item img {
      width: 100%;
      height: 100%;
      max-width: 245px;
      max-height: 320px;
      display: block;
      margin: 0 auto;
    }

    .item h5 {
      margin-top: 10px;
      font-size: 16px;
    }

    .image-container {
      position: relative;
    }

    .image-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      /* font-size: 54px; */
      font-weight: bold;
      color: white;
      text-align: center;
      width: 100%;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
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

    .modal-backdrop {
      z-index: 0 !important;
    }
    .navbar-nav {
      display: flex;
      align-items: center;
    }

    .nav-item {
      display: flex;
      align-items: center;
      padding: 5px 5px;
    }

    #mobile-header {
      padding: 0.5rem 12%;
    }

    @media (max-width: 768px) {
      #mobile-header {
        padding: 1rem;
      }
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
            <h6 class="mt-4 mb-2" style="font-weight: bold;">Account Details</h6>
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
            <h6 class="mt-4 mb-2" style="font-weight: bold;">Address Details</h6>
            <div class="mb-3">
              <label for="block_number" class="form-label">Block/House/Unit Number</label>
              <input type="text" class="form-control" id="block_number" name="block_number"
                value="<?php echo $row['block_number']; ?>">
            </div>
            <div class="mb-3">
              <label for="street" class="form-label">Street</label>
              <input type="text" class="form-control" id="street" name="street"
                value="<?php echo $row['street']; ?>">
            </div>
            <div class="mb-3">
              <label for="barangay" class="form-label">Barangay</label>
              <input type="text" class="form-control" id="barangay" name="barangay"
                value="<?php echo $row['barangay']; ?>">
            </div>
            <div class="mb-3">
              <label for="city" class="form-label">City</label>
              <input type="text" class="form-control" id="city" name="city"
                value="<?php echo $row['city']; ?>">
            </div>
            <h6 class="mt-4 mb-2" style="font-weight: bold;">Avatar</h6>
            <div class="mb-3">
              <!-- Display current avatar if exists -->
              <?php if (isset($row['avatar'])): ?>
                <div>
                  <img src="<?php echo $row['avatar']; ?>" alt="Avatar" width="100">
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
  <!-- Include Bootstrap JS -->
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
            alert("Profile updated successfully!");
            location.reload();
          },
          error: function (xhr, status, error) {
            alert("An error occurred: " + error);
          }
        });
      });
    });
  </script>

  <nav class="navbar navbar-expand-lg navbar-light bg-light" id="mobile-header">
    <div class="container-fluid navcontainer">

      <a class="navbar-brand" href="index.php">KOFEE MANILA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="mobileMenu">
      <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="menu.php">Menu</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
          <?php
          if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
            echo "
            <li class='mav-item'>
             <a class='cart-icon' href='cart.php' style='color: #000; font-size: 16px; text-decoration: none; text-align:center;'>
              <i class='fas fa-shopping-cart'></i>
              My Cart
            </a>
            </li>
           ";
          }
        ?>
          <!-- Bootstrap CSS -->

          <?php if (isset($_SESSION['userid'])): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <!-- Profile image -->
                <img
                  src="<?php echo $_SESSION['avatar']; ?>"
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
            <li class="nav-item mr-2">
              <a class="nav-link sign-in" href="login.php">Sign In</a>
            </li>
            <li class="nav-item">
              <a class="nav-link join-now" href="register.php">Join Now</a>
            </li>
          <?php endif; ?>
        </ul>
        
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="lc.js"></script>
  
  <style>
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
  </style>

  <script type="module">
      import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
      import { getFirestore, collection, addDoc, onSnapshot } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";

      const firebaseConfig = {
        apiKey: "AIzaSyDjWfyGpv_ECHnkHABYEss7J0unCrLH0ok",
        authDomain: "kofee-manila.firebaseapp.com",
        databaseURL: "https://kofee-manila-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "kofee-manila",
        storageBucket: "kofee-manila.appspot.com",
        messagingSenderId: "296750304629",
        appId: "1:296750304629:web:39d6e2d377dfff5984d73c"
      };

      // Initialize Firebase
      const app = initializeApp(firebaseConfig);
      const db = getFirestore(app);
      const updates = collection(db, "user_updates");

      let userid = <?php echo $_SESSION['userid']; ?>;

      // Add a new document to the logs collection
      onSnapshot(updates, (snapshot) => {
        snapshot.docChanges().forEach((change) => {
          console.log(change.doc.data())

          let realtimedata = change.doc.data();

          if(realtimedata.userid == userid){
            if(change.type === "modified"){
              alert(realtimedata.message)
            }
          }
        });
      });
  </script>
  
</body>
</html>