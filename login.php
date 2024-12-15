<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - KOFEE MANILA</title>
  <link rel="icon" type="image/png" sizes="32x32" href="assets/items/favicon.ico">
  <script src="libs/jquery.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: "Montserrat", sans-serif;
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
            <h2 class="text-center mb-4 D68C1E">Log In</h2>
            <div class="container-shadow">
              <form id="login-frm">
                <div class="form-group">
                  <input type="email" class="form-control" id="logemail" placeholder="Enter your email" />
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="password" class="form-control" id="logpassword" placeholder="Enter your password" />
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button"
                        onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <button type="submit" style="background-color: #D68C1E; color: #fff;" class="btn btn-lg btn-block">Sign In</button>
              </form>
              <p class="text-center mt-3">
                No account yet? <a href="register.php">Join us here</a>
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
    function togglePasswordVisibility() {
      var input = document.getElementById("logpassword");
      if (input.type === "password") {
        input.type = "text";
      } else {
        input.type = "password";
      }
    }
  </script>
  <script>

    $("#login-frm").on("submit", function(event){
      event.preventDefault();

      var logemail = $("#logemail").val();
      var logpassword = $("#logpassword").val();

      $.ajax({
        url : "api/login.php",
        type: "post",
        data: {
          email: logemail,
          password: logpassword
        },
        success: response => {
          if(response == "Need to verify account first"){
            Swal.fire({
              title: "Account Not Verified",
              text: response,
              icon: "info"
            });
          }else if(response == "Logged In Successfully"){
            Swal.fire({
              title: "Welcome!",
              text: response,
              icon: 'success',
              showCancelButton: false,
              confirmButtonText: "Ok"
            }).then((result) => {
              location.href = "menu.php"
            });
          }else {
            Swal.fire({
              title: "Account Login Failed",
              text: "Invalid email and password",
              icon: "error"
            });
          }
        }
      })
    })

    $(document).ready(function(){
      
    })
  </script>

  <!-- Bootstrap JS, Popper.js, and jQuery (Optional) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>