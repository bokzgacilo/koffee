<?php
  include("../../api/connection.php");

  header('Content-Type: application/json');

  $select_all = $conn->query("SELECT * FROM refund");

  $data = [];

  while ($row = $select_all -> fetch_assoc()) {
    $clientid = $row['client_id'];
    $getclientname = $conn -> query("SELECT * FROM users WHERE id=$clientid");
    $client = $getclientname -> fetch_assoc();

    $row['client_name'] = $client['firstname'] . " " . $client['lastname'];
    
    $data[] = $row;
  }

  echo json_encode([
    "data" => $data
  ]);

  $conn -> close();
?>