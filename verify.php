<?php
  include("api/connection.php");

  $userid = $_GET['userid'];
  $code = $_GET['code'];

  $update = $conn -> query("UPDATE users SET is_verify=true WHERE id=$userid AND verification_code='$code'");

  if($update){
    echo "<p>Email verified</p>";
    echo "<a href='index.php'>Go To Kofee Manila</a>";
  }else {
    echo "Invalid verification link";
  }
?>