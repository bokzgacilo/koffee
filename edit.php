<?php
require_once('config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Handle password change (not hashing for simplicity, adjust as needed)
    $user_id = $_SESSION['userid'];
    $block_number = $_POST['block_number'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $avatar_path = "";
    // Handle avatar upload
    $target_dir = "uploads/avatars/";  // Define the full directory path here

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $originalFileName = $_FILES['avatar']['name'];
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $newFileName = "avatar_$user_id" . '.' . $fileExtension;

        $target_file = $target_dir . $newFileName;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
          $avatar_path = $target_file;  // Store full path
        } else {
          $avatar_path = $_SESSION['avatar'];
        }
    } else {
      $avatar_path = $_SESSION['avatar'];
    }

    // Create a new database connection
    $db = new DBConnection();

    // Prepare and execute the query to update the user's data
    $query = $db->conn->prepare("UPDATE users SET firstname = ?, lastname = ?, username = ?, password = ?, avatar = ?, block_number = ?, street = ?, barangay = ?, city = ? WHERE id = ?");
    $query->bind_param("sssssssssi", $firstname, $lastname, $email, $password, $avatar_path, $block_number, $street, $barangay, $city, $user_id);

    if ($query->execute()) {
        // Update session da
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['avatar'] = $avatar_path;  // Store full path in the session as well

    } else {
        echo '<script>alert("Error updating profile.");</script>';
    }
}

?>