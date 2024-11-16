<?php
  date_default_timezone_set('Asia/Manila');

  $servername = "localhost"; 
  $username = "root";   
  $password = "";   
  $database = "koffee";     

  // Create a connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>