<?php
  include_once('initialize.php');

  date_default_timezone_set('Asia/Manila');

  $servername = DB_SERVER;
  $username = DB_USERNAME;
  $password = DB_PASSWORD;
  $database = DB_NAME; 

  $conn = new mysqli($servername, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>