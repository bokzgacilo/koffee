<?php
require_once('config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Handle password change (not hashing for simplicity, adjust as needed)
    $user_id = $_SESSION['user_id'];

    // Handle avatar upload
    $target_dir = "uploads/avatars/";  // Define the full directory path here

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $avatar_name = $user_id . ".png";  // Save as user ID
        $target_file = $target_dir . $avatar_name;  // Full path including directory

        // Save the avatar in the correct location
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
            $avatar_path = $target_file;  // Store full path with versioning
        } else {
            echo '<script>alert("Failed to upload avatar.");</script>';
            $avatar_path = $_SESSION['avatar'];  // Keep the existing avatar
        }
    } else {
        $avatar_path = $_SESSION['avatar'];  // Keep the existing avatar if no new upload
    }

    // Create a new database connection
    $db = new DBConnection();

    // Prepare and execute the query to update the user's data
    $query = $db->conn->prepare("UPDATE users SET firstname = ?, lastname = ?, username = ?, password = ?, avatar = ? WHERE id = ?");
    $hashed_password = md5($password);  // Optionally hash the password
    $query->bind_param("sssssi", $firstname, $lastname, $email, $hashed_password, $avatar_path, $user_id);

    if ($query->execute()) {
        // Update session data
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['avatar'] = $avatar_path;  // Store full path in the session as well

        // echo '<script>window.location.href="index.php";</script>';
    } else {
        echo '<script>alert("Error updating profile.");</script>';
    }
}

?>