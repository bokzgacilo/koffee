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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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
            <h2 class="text-center mb-4 D68C1E">CREATE AN ACCOUNT</h2>
            <div class="container-shadow">
              <form id="registerForm">
                <div class="form-group">
                  <input type="text" class="form-control" id="rfirstname" placeholder="Enter your first name" required />
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="rlastname" placeholder="Enter your last name" required />
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" id="remail" placeholder="Enter your email" required />
                </div>
                <div class="form-group">
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
                <div class="form-group">
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
                <button id="registerButton" disabled type="submit" class="btn btn-lg bg-D68C1E btn-primary btn-block">
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
          <h2>Kofee Manila - Terms and Conditions</h2>

          <p>Welcome to Kofee Manila! These terms and conditions outline the rules and regulations for the use of our services. By accessing and placing an order on Kofee Manila, you accept these terms and conditions in full. Do not continue to use Kofee Manila if you do not agree to all of the terms and conditions stated on this page.</p>

          <h3>1. Ordering Process</h3>
          <p>All orders placed through our website are subject to product availability. We reserve the right to limit the quantities of any products or services that we offer. We may, in our sole discretion, limit or cancel orders placed through our website.</p>

          <h3>2. Pricing and Payment</h3>
          <p>All prices displayed on our website are in PHP and inclusive of applicable taxes. We reserve the right to change prices at any time without notice. Payments must be made at the time of ordering, through the available payment methods, which include credit/debit cards or cash on delivery.</p>

          <h3>3. Delivery Policy</h3>
          <p>Delivery times may vary depending on location and order size. We will do our best to deliver your order within the estimated time frame provided at checkout, but we do not guarantee delivery times. Kofee Manila is not responsible for any delays caused by unforeseen circumstances.</p>

          <h3>4. Cancellation and Refunds</h3>
          <p>Orders can only be cancelled within 5 minutes after the order is placed. If the cancellation request is made after this time, we may not be able to stop the order, and no refund will be provided. In the event of a product being unavailable after an order has been placed, we will offer a replacement or a full refund.</p>

          <h3>5. Allergies and Dietary Requirements</h3>
          <p>It is your responsibility to notify us of any allergies or dietary requirements when placing your order. While we take care to prepare food according to customer specifications, we cannot guarantee that any of our products are completely free from allergens.</p>

          <h3>6. Limitation of Liability</h3>
          <p>Kofee Manila shall not be liable for any direct, indirect, incidental, special, or consequential damages arising out of your use of our services or products. We strive to provide accurate and up-to-date information on our website, but we do not guarantee that all information is free from errors.</p>

          <h3>7. Changes to Terms and Conditions</h3>
          <p>Kofee Manila reserves the right to modify these terms and conditions at any time. Changes will be effective immediately upon posting to our website. By continuing to use our services after any changes are posted, you agree to be bound by the updated terms and conditions.</p>

          <h3>8. Contact Us</h3>
          <p>If you have any questions about our terms and conditions, feel free to contact us at <a href="mailto:info@kofeemanila.com">info@kofeemanila.com</a>.</p>

          <p><strong>Last Updated: October 2024</strong></p>
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