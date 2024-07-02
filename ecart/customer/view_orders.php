<?php
require 'customer_authgaurd.php';
require '../shared/connection.php'; // Include the database connection

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Orders</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class = "container-fluid">
            <a class="navbar-brand" href="#">Ecart</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="cart_view.php">View Cart</a>
                </li>
                <li>
                    <a class="nav-link "  href="view_orders.php">My Orders</a>
                </li>
            </ul>
            <?php echo"<a class='navbar-brand'> Welcome $_SESSION[username]</a>"; ?>

            <form action="../shared/logout.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button class=" btn btn-danger" type="submit">Logout</button>
            </form>
        </div>
    </nav>   


<?php
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to login page if not logged in
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch orders for the logged-in user
$sql = "SELECT * FROM orders WHERE user_id='$user_id' ORDER BY order_date DESC";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
   
    while ($row = $result->fetch_assoc()) {
        echo "Order ID: " . $row["order_id"] . "<br>";
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
        echo "<hr>";
    }
} else {
    echo "You have no orders.";
}
?>
</body>
</html>