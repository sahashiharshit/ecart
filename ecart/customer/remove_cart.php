<?php
require 'customer_authgaurd.php';
require '../shared/connection.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to login page if not logged in
    exit();
}

// Get cart item ID from URL
if (!isset($_GET['cart_item_id'])) {
    echo "Cart item ID is required.";
    exit();
}

$cart_item_id = $_GET['cart_item_id'];

// Check if the cart item belongs to the logged-in user
$sql = "SELECT * FROM cart WHERE cart_item_id='$cart_item_id' AND user_id='" . $_SESSION['user_id'] . "'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // Mark the cart item as removed
    $delete_sql = "UPDATE cart SET status='removed' WHERE cart_item_id='$cart_item_id'";
    if ($connection->query($delete_sql) === TRUE) {
        header('Location: cart_view.php'); // Redirect to cart page after removal
        exit();
    } else {
        echo "Error: " . $delete_sql . "<br>" . $connection->error;
    }
} else {
    echo "No cart item found or you don't have permission to delete this item.";
}
?>