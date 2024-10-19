<?php
  include("connection.php");
  session_start();

  $feedback = $_POST['feedback'];
  $rating = $_POST['rating'];

  

  $insert = $conn -> query("INSERT INTO customer_feedback (customer_name, customer_email, feedback, rating) VALUES(
    '". $_SESSION['userfullname']."',
    '". $_SESSION['useremail']."',
    '$feedback',
    $rating
  )");

  if($insert){
    echo "Feedback Submitted";
  }else {
    echo "Error submitting feedback. Please try again.";
  }

  $conn -> close();

?>