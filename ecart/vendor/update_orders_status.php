<?php
require 'authgaurd.php';
require '../shared/connection.php'; // Include the database connection

// Check if the admin is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to admin login page if not logged in
    exit();
}

// Get order ID and new status from POST request
$order_id = $_POST['order_id'];
$status = $_POST['status'];

// Update order status
$sql = "UPDATE orders SET status='$status' WHERE order_id='$order_id'";
if ($connection->query($sql) === TRUE) {
    header('Location: manage_orders.php'); // Redirect to the manage orders page after updating status
    exit();
} else {
    echo "Error updating record: " . $connection->error;
}
?>
