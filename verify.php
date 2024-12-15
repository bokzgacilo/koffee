<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KOFEE MANILA</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <!-- Bootstrap JS, Popper.js, and jQuery (Optional) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <style>


  </style>
</head>

<body>
  <!-- Navbar Section -->

  <div class="p-4">
    <?php
      session_start();
      include("api/connection.php");

      $userid = $_GET['userid'];
      $code = $_GET['code'];

      $update = $conn -> query("UPDATE users SET is_verify=true WHERE id=$userid AND verification_code='$code'");

      if($update){
        $user = $conn -> query("SELECT * FROM users WHERE id=$userid");
        $user = $user -> fetch_assoc();

        $_SESSION['userid'] = $user['id'];
        $_SESSION['avatar'] = "uploads/avatars/9.png";
        $_SESSION['userfullname'] = $user['firstname'] . " " . $user['lastname'];
        $_SESSION['useremail'] = $user['username'];
        $_SESSION['avatar'] = $user['avatar'];
        
        echo "<h4 class='mb-4'>Email Verified!</h4>";
        echo "<a href='index.php' class='btn btn-primary'>Go To Kofee Manila</a>";
      }else {
        echo "Invalid verification link";
      }
    ?>
  </div>
 

</body>

</html>