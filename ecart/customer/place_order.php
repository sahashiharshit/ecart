<?php
require 'customer_authgaurd.php'; //Include the customer authentication machenism.
require '../shared/connection.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to login page if not logged in
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$sql = "SELECT cart.*, product.price FROM cart JOIN product ON cart.product_id = product.pid WHERE cart.user_id='$user_id' AND cart.status='active'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $total_amount = 0;
    $cart_items = [];

    // Calculate total amount and prepare cart items for insertion into order_items
    while ($row = $result->fetch_assoc()) {
        $total_amount += $row['quantity'] * $row['price'];
        $cart_items[] = $row;
    }

    // Insert new order
    $insert_order_sql = "INSERT INTO orders (user_id, total_amount) VALUES ('$user_id', '$total_amount')";
    if ($connection->query($insert_order_sql) === TRUE) {
        $order_id = $connection->insert_id; // Get the ID of the newly created order

        // Insert order items
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $insert_order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$price')";
            if ($connection->query($insert_order_item_sql) !== TRUE) {
                echo "Error: " . $insert_order_item_sql . "<br>" . $connection->error;
            }
        }

        // Mark cart items as ordered
        $update_cart_sql = "UPDATE cart SET status='ordered' WHERE user_id='$user_id' AND status='active'";
        if ($connection->query($update_cart_sql) === TRUE) {

            header('Location:payment.php?order_id=' . $order_id);
            exit();
        } else {
            echo "Error updating cart: " . $connection->error;
        }
    } else {
        echo "Error: " . $insert_order_sql . "<br>" . $connection->error;
    }
} else {
    echo "Your cart is empty.";
}
?>