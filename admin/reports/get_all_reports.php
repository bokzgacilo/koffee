<?php
  include("../../api/connection.php");

  header('Content-Type: application/json');


  $date = $_GET['orderdate'];
  
  
  $userid = $_GET['userid'];

  $sql = "";

  if($userid == 0 && $date == ""){
    $sql = "SELECT * FROM orders";
  }else if($userid != 0) {
    // expected date 2024-11-10
    $sql = "SELECT * FROM orders WHERE client_id=$userid";
  }else if($date != "") {
    // expected date 2024-11-10
    $sql = "SELECT * FROM orders WHERE today_date='$date'";
  }else {
    $sql = "SELECT * FROM orders WHERE today_date='$date' AND client_id=$userid";
  }

  $select_all = $conn->query($sql);

  $data = [];

  while ($row = $select_all -> fetch_assoc()) {
    $clientid = $row['client_id'];
    $getclientname = $conn -> query("SELECT * FROM users WHERE id=$clientid");
    $client = $getclientname -> fetch_assoc();

    $row['client_name'] = $client['firstname'] . " " . $client['lastname'];
    $row['date_ordered'] = date("M d, Y", strtotime($row['order_date']));
    
    $data[] = $row;
  }

  
  echo json_encode([
    "data" => $data
  ]);

  $conn -> close();
?>