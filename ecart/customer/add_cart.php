<?php 

require 'customer_authgaurd.php';

require '../shared/connection.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to login page if not logged in
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

$product_id = $_POST['pid'];
$quantity = $_POST['quantity'];
$sql = "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id' AND status='active'";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    // If the product is already in the cart, update the quantity
    $row = $result->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;
    $update_sql = "UPDATE cart SET quantity='$new_quantity', added_date=CURRENT_TIMESTAMP WHERE cart_item_id='" . $row['cart_item_id'] . "'";
    if ($connection->query($update_sql) === TRUE) {
        echo "Product quantity updated in cart.";
    } else {
        echo "Error updating record: " . $connection->error;
    }
} else {
    // If the product is not in the cart, insert a new record
    $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', '$quantity')";
    if ($connection->query($insert_sql) === TRUE) {
        echo "Product added to cart.";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $connection->error;
    }
}

header('Location: home.php');
?>