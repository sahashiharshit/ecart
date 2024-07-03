<?php
require 'customer_authgaurd.php';
require '../shared/connection.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to login page if not logged in
    exit();
}

// Get data from POST request
$order_id = $_POST['order_id'];
$amount = $_POST['amount'];
$payment_method = $_POST['payment_method'];

// Process payment (simulated)
$payment_status = ($payment_method == 'online') ? 'paid' : 'pending';

// Insert payment record
$insert_payment_sql = "INSERT INTO payments (order_id, amount, payment_method) VALUES ('$order_id', '$amount', '$payment_method')";
if ($connection->query($insert_payment_sql) === TRUE) {
    // Update order payment status
    $update_order_sql = "UPDATE orders SET payment_status='$payment_status', status='pending' WHERE order_id='$order_id'";
    if ($connection->query($update_order_sql) === TRUE) {
        echo "Payment processed successfully. Your order is now " . ($payment_status == 'paid' ? "completed." : "pending payment.");
        echo "<br>Redirecting to home page...";
        header('Refresh:3,url=home.php');
    } else {
        echo "Error updating order: " . $connection->error;
    }
} else {
    echo "Error: " . $insert_payment_sql . "<br>" . $connection->error;
}
?>