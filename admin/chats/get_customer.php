<?php
  include("../../api/connection.php");

  $ids = $_POST['ids'];
  $chatid = $_POST['selected'];

  foreach ($ids as $id) {
    $user = $conn -> query("SELECT firstname, lastname, avatar FROM users WHERE id=$id LIMIT 1");
    $user = $user -> fetch_assoc();

    $newclass = "";

    if($id === $chatid){
      $newclass = " is-selected";
    }

    echo "
      <a id='client-$id' class='$newclass' href='?page=chats&cid={$id}'>
        <img src='../{$user['avatar']}' />
        {$user['lastname']}, {$user['firstname']}
      </a>
    ";
  }


  $conn -> close();
?>