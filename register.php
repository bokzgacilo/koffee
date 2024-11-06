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
  <title>Create an Account - KOFEE MANILA</title>
  <script src="libs/jquery.js"></script>
  <script src="libs/popper.js"></script>

  <script src="libs/bootstrap.min.js"></script>
  <link href="libs/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <div class="container-shadow">
              <h1 class="text-center mb-4">CREATE AN ACCOUNT</h1>

              <form id="registerForm">
                <div class="form-group mb-2">
                  <input type="text" class="form-control" id="rfirstname" placeholder="Enter your first name" required />
                </div>
                <div class="form-group mb-2">
                  <input type="text" class="form-control" id="rlastname" placeholder="Enter your last name" required />
                </div>
                <div class="form-group mb-2">
                  <input type="email" class="form-control" id="remail" placeholder="Enter your email" required />
                </div>
                <div class="form-group mb-2">
                  <div class="input-group">
                    <input type="password" class="form-control" id="rpassword"
                      placeholder="Enter your password" required />
                    <div class="input-group-append">
                      <button style="z-index: 1;" class="btn btn-outline-secondary" type="button"
                        onclick="togglePasswordVisibility('password')">
                        <i class="fas fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-2">
                  <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password"
                      placeholder="Confirm your password" required />
                    <div class="input-group-append">
                      <button style="z-index: 1;" class="btn btn-outline-secondary" type="button"
                        onclick="togglePasswordVisibility('confirm_password')">
                        <i class="fas fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="form-check mt-4 mb-4">
                  <input type="checkbox" class="form-check-input" id="termsCheckbox">
                  <label class="form-check-label" for="termsCheckbox">
                    I agree to the <a href="#" id="showTermsLink">Terms and Conditions</a>
                  </label>
                </div>
                <button id="registerButton" disabled type="submit" style="background-color: #D68C1E; color: #fff;" class="btn btn-lg w-100">
                  Register
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
 <!-- Modal -->
 <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="termsModalLabel">Kofee Manila - Terms and Conditions</h5>
          </div>
          <div class="modal-body">
            <?php echo $contact['terms_and_condition']; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="agreeButton">Agree</button>
          </div>
        </div>
      </div>
    </div>
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

  <script>
    $(document).ready(function() {
      // When the checkbox is checked, show the modal
      $('#termsCheckbox').on('change', function() {
        if ($(this).is(':checked')) {
          $('#termsModal').modal('show');
          $("#registerButton").removeAttr('disabled')
        }
      });

      // When the "Agree" button in the modal is clicked, close the modal
      $('#agreeButton').on('click', function() {
        $('#termsModal').modal('hide');
      });

      // Optionally, prevent the checkbox from being unchecked without agreeing
      $('#termsModal').on('hidden.bs.modal', function () {
        if (!$('#agreeButton').data('agreed')) {
          $('#termsCheckbox').prop('checked', false);
          $("#registerButton").attr('disabled','disabled')
        }
      });

      // Set the agree flag when the "Agree" button is clicked
      $('#agreeButton').on('click', function() {
        $(this).data('agreed', true);
      });
    });

    $(document).ready(function(){
      $("#registerForm").on("submit", function(event){
      event.preventDefault();

      var firstname = $("#rfirstname").val();
      var lastname = $("#rlastname").val();
      var email = $("#remail").val();
      var password = $("#rpassword").val();

      $.ajax({
        type: "post",
        url: "api/register_client.php",
        data: {
          firstname: firstname,
          lastname: lastname,
          email: email,
          password: password,
        },
        success: response => {
          console.log(response)

          if(response == "success"){
            Swal.fire({
              title: "Registered Successfully",
              text: "Please check your email for verification message.",
              icon: "success"
            });
          }else {
            Swal.fire({
              title: "Register Failed",
              text: response,
              icon: "info"
            });
          }
        }
      })
    })
    })
    
  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>