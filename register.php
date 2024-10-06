<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the form data
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $password = $_POST['password']; // Hash the entered password with MD5

  // Create a new database connection
  $db = new DBConnection();

  // Check if the email already exists
  $checkQuery = $db->conn->prepare("SELECT id FROM users WHERE username = ?");
  $checkQuery->bind_param("s", $email);
  $checkQuery->execute();
  $checkQuery->store_result();

  if ($checkQuery->num_rows > 0) {
    echo '<script>alert("This email is already registered. Please use a different email.");</script>';
  } else {
    $type = 2; // Set user type
    $avatar = "uploads/avatars/9.png";
    // Prepare and execute the query to insert the new user
    $query = $db->conn->prepare("INSERT INTO users (firstname, lastname, username, password, type, avatar) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $firstname, $lastname, $email, $password, $type, $avatar);

    if ($query->execute()) {
      // Automatically log in the user
      $_SESSION['user_id'] = $query->insert_id; // Get the newly inserted user id
      $_SESSION['firstname'] = $firstname;
      $_SESSION['lastname'] = $lastname;
      $_SESSION['password'] = $_POST['password'];
      $_SESSION['username'] = $email;

      // Redirect to home page
      echo '<script>window.location.href="index.php"</script>';
      exit;
    } else {
      echo '<script>alert("There was an error creating your account. Please try again.");</script>';
    }

    // Close the insert query
    $query->close();
  }

  // Close the check query
  $checkQuery->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create an Account - KOFEE MANILA</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <style>
    /* Style for form inputs */

    body {
      font-family: "Montserrat", sans-serif;
      /* Apply Montserrat font to entire body */
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .container-shadow {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
    }

    .main-content {
      flex: 1;
    }

    /* Webkit Scrollbar Styles */
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
  </style>
</head>

<body>
  <!-- Navbar Section -->
  <?php include "includes/navbar.php"; ?>

  <!-- Create Account Form Section -->
  <div class="main-content">
    <section class="py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <h2 class="text-center mb-4 D68C1E">CREATE AN ACCOUNT</h2>
            <div class="container-shadow">
              <form method="POST" action="register.php">
                <div class="form-group">
                  <input type="text" class="form-control" name="firstname" id="firstname"
                    placeholder="Enter your first name" required />
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="lastname" id="lastname"
                    placeholder="Enter your last name" required />
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email"
                    required />
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="password" class="form-control" name="password" id="password"
                      placeholder="Enter your password" required />
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button"
                        onclick="togglePasswordVisibility('password')">
                        <i class="fas fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password"
                      placeholder="Confirm your password" required />
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button"
                        onclick="togglePasswordVisibility('confirm_password')">
                        <i class="fas fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-lg bg-D68C1E btn-primary btn-block">
                  Create Account
                </button>
              </form>

              <p class="text-center mt-3">
                Already have an account? <a href="login.php">Sign in here</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer Section -->
  <?php include "includes/footer.php"; ?>
  <script>
    document.querySelector("form").addEventListener("submit", function (e) {
      var password = document.getElementById("password").value;
      var confirmPassword = document.getElementById("confirm_password").value;

      if (password !== confirmPassword) {
        e.preventDefault();
        alert("Passwords do not match. Please try again.");
      }
    });

    function togglePasswordVisibility(id) {
      var input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
      } else {
        input.type = "password";
      }
    }
  </script>

  <!-- Bootstrap JS, Popper.js, and jQuery (Optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>