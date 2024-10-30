
<?php
  session_start();

  if(!isset($_SESSION['adminauth'])){
    
    
  }else {
    header("location: index.php");
  }
?>

<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<body class="hold-transition login-page">
  <style>
    body {
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-size: cover;
      background-repeat: no-repeat;
      backdrop-filter: contrast(1);
    }

    #page-title {
      text-shadow: 6px 4px 7px black;
      font-size: 3.5em;
      color: #fff4f4 !important;
      background: #8080801c;
    }
  </style>
  <h1 class="text-center text-white px-4 py-5" id="page-title"><b><?php echo $_settings->info('name') ?></b></h1>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-navy my-2">
      <div class="card-body">
        <p class="login-box-msg">Please enter your credentials</p>
        <form id="adminloginform">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="adminusername" name="username" autofocus placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="adminpassword" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <button type="submit" class="col btn btn-primary btn-block">Sign In</button>
        </form>
        <!-- /.social-auth-links -->

        <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function () {
      $("#adminloginform").on("submit", function(event){
        event.preventDefault();

        var logemail = $("#adminusername").val();
        var logpassword = $("#adminpassword").val();

        $.ajax({
          type: 'post',
          url: '../api/admin_login.php',
          data: {
            username : logemail,
            password: logpassword
          },
          success: response => {
            if(response === "ok"){
              location.reload()
            }else {
              alert(response)
            }
          }
        })
      })
    })
  </script>
</body>

</html>