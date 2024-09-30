<?php
  date_default_timezone_set('Asia/Manila');

  $servername = "localhost"; // Replace with your server name
  $username = "root";    // Replace with your database username
  $password = "";    // Replace with your database password
  $database = "koffee";      // Replace with your database name

  // Create a connection
  $conn = new mysqli($servername, $username, $password, $database);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>