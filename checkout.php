<?php
session_start();
require 'connection.php'; // Ensure you have a connection.php file for your DB connection

// Assuming you're using POST to send the cart data from the frontend
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; // Assuming you store user_id in session
    $note = isset($_POST['note']) ? $_POST['note'] : ''; // Optional note
    $payment_type = isset($_POST['payment_type']) ? (int) $_POST['payment_type'] : 1; // Payment type from POST
    $tendered = isset($_POST['tendered']) ? (float) $_POST['tendered'] : 0; // Tendered amount
    $cart = isset($_POST['cart']) ? json_decode($_POST['cart'], true) : []; // Cart items from POST

    if (empty($cart)) {
        echo "No items in the cart.";
        exit;
    }

    // Generate a unique payment code (timestamp + random number or any other method)
    $payment_code = 'PAY' . time() . rand(1000, 9999);

    // Calculate total amount
    $total_amount = 0;
    foreach ($cart as $item) {
        $total_amount += (float) $item['price'] * (int) $item['quantity'];
    }

    try {
        // Connect to the database
        $conn = new PDO("mysql:host=localhost;dbname=your_database_name", 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Start transaction
        $conn->beginTransaction();

        // Loop through cart and insert each item into sale_list
        foreach ($cart as $item) {
            $stmt = $conn->prepare("INSERT INTO sale_list (user_id, note, amount, tendered, payment_type, payment_code, quantity, attribute) 
                                    VALUES (:user_id, :note, :amount, :tendered, :payment_type, :payment_code, :quantity, :attribute)");

            $stmt->execute([
                'user_id' => $user_id,
                'note' => $note,
                'amount' => (float) $item['price'],
                'tendered' => $tendered,
                'payment_type' => $payment_type,
                'payment_code' => $payment_code,
                'quantity' => (int) $item['quantity'],
                'attribute' => $item['attribute'] // Assuming 'attribute' could be size, addon, etc.
            ]);
        }

        // Commit transaction
        $conn->commit();

        // Redirect to orders page after successful checkout
        header("Location: orders.php");
        exit;
    } catch (PDOException $e) {
        // Rollback transaction if something goes wrong
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
