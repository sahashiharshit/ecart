<?php
require 'customer_authgaurd.php';
require '../shared/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to login page if not logged in
    exit();
}


// Get order ID from GET request
$order_id = $_GET['order_id'];

// Fetch order details
$sql = "SELECT * FROM orders WHERE order_id='$order_id' AND user_id='$_SESSION[user_id]'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    echo "<h1>Order ID: " . $order['order_id'] . "</h1>";
    echo "<p>Total Amount: $" . $order['total_amount'] . "</p>";

    // Payment form
    echo "<form action='process_payment.php' method='post'>";
    echo "<input type='hidden' name='order_id' value='" . $order['order_id'] . "'>";
    echo "<input type='hidden' name='amount' value='" . $order['total_amount'] . "'>";
    echo "<label for='payment_method'>Choose a payment method:</label><br>";
    echo "<input type='radio' id='online' name='payment_method' value='online' checked>";
    echo "<label for='online'>Online Payment</label><br>";
    echo "<input type='radio' id='cod' name='payment_method' value='cod'>";
    echo "<label for='cod'>Cash on Delivery</label><br><br>";
    echo "<input type='submit' value='Pay Now'>";
    echo "</form>";
} else {
    echo "Order not found.";
}
?>