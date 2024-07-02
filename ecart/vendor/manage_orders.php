
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <style>
        .order {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px 0;
        }
        .order-items {
            margin-left: 20px;
        }
        form {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php
require 'authgaurd.php';
require '../shared/connection.php'; // Include the database connection

// Check if the admin is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to admin login page if not logged in
    exit();
}

// Fetch all orders
$sql = "SELECT orders.*, user.username FROM orders JOIN user ON orders.user_id = user.user_id ORDER BY order_date DESC";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Manage Orders</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='order'>";
        echo "Order ID: " . $row["order_id"] . "<br>";
        echo "Customer: " . $row["username"] . "<br>";
        echo "Order Date: " . $row["order_date"] . "<br>";
        echo "Total Amount: " . $row["total_amount"] . "<br>";
        echo "Status: " . $row["status"] . "<br>";

        // Fetch order items for each order
        $order_id = $row["order_id"];
        $items_sql = "SELECT order_items.*, product.pname FROM order_items JOIN product ON order_items.product_id = product.pid WHERE order_id='$order_id'";
        $items_result = $connection->query($items_sql);

        if ($items_result->num_rows > 0) {
            echo "Items:<br>";
            while ($item_row = $items_result->fetch_assoc()) {
                echo "- Product: " . $item_row["pname"] . " | Quantity: " . $item_row["quantity"] . " | Price: " . $item_row["price"] . "<br>";
            }
        }

        // Form to update order status
        echo "<form action='update_orders_status.php' method='post'>";
        echo "<input type='hidden' name='order_id' value='" . $row["order_id"] . "'>";
        echo "<label for='status'>Update Status:</label>";
        echo "<select name='status' id='status'>";
        echo "<option value='pending'" . ($row["status"] == "pending" ? " selected" : "") . ">Pending</option>";
        echo "<option value='completed'" . ($row["status"] == "completed" ? " selected" : "") . ">Completed</option>";
        echo "<option value='cancelled'" . ($row["status"] == "cancelled" ? " selected" : "") . ">Cancelled</option>";
        echo "</select>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";

        echo "</div><hr>";
    }
} else {
    echo "No orders found.";
}
?>
</body>
</html>