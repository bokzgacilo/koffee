<?php
  include("connection.php");
  session_start();

  $feedback = $_POST['feedback'];
  $rating = $_POST['rating'];
  $orderid = $_POST['orderid'];
  
  $userfullname = $_SESSION['userfullname'];
  $useremail = $_SESSION['useremail'];

  $insert = $conn -> query("INSERT INTO customer_feedback (customer_name, customer_email, feedback, rating) VALUES(
    '$userfullname',
    '$useremail',
    '$feedback',
    $rating
  )");

  if($insert){
      $conn -> query("UPDATE orders SET is_reviewed=TRUE WHERE id=$orderid");

      echo "Feedback Submitted";
  }else {
    echo "Error submitting feedback. Please try again.";
  }

  $conn -> close();

?>