<?php 
require 'authgaurd.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">  
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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class = "container-fluid">
    <a class="navbar-brand" href="#">Vendor Dashboard</a>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="home.php">Upload Inventory</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="view_product.php">View Inventory</a>
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

require '../shared/connection.php'; // Include the database connection

// Check if the admin is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../shared/login.php'); // Redirect to admin login page if not logged in
    exit();
}

// Fetch all orders
$sql = "SELECT orders.*, user.username FROM orders JOIN user ON orders.user_id = user.user_id ORDER BY order_date DESC";
$result = $connection->query($sql);
$count =0;
if ($result->num_rows > 0) {
    // echo "<h1>Manage Orders</h1>";
    echo "<div class='album py-5 bg-body-tertiary'>
        <div class='container'>
         <div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3'>";
    while ($row = $result->fetch_assoc()) {
        $count++;
        echo " <div class='col'>
        <div class='card shadow-sm'>
         <div class='card-body'>";
        echo "<text>Order ID: $row[order_id]</text></br>";
        echo "<text>Customer: $row[username]</text></br>";
        echo "<text>Total Amount: $row[total_amount]</text></br>";
        echo "<text>Status: $row[status]</text></br>";
        echo "<small class='text-body-secondary'>Order Date: $row[order_date]</small></br>";
        
        // Fetch order items for each order
        $order_id = $row["order_id"];
        $items_sql = "SELECT order_items.*,product.imgpath, product.pname FROM order_items JOIN product ON order_items.product_id = product.pid WHERE order_id='$order_id'";
        $items_result = $connection->query($items_sql);
        if ($items_result->num_rows > 0) {
            
            echo "<div class='accordion' id='itemsAccordion". $count ."'>";
            echo " <div class='accordion-item'>";
            echo "<h2 class='accordion-header'>
                    <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapseOne".$count."' aria-expanded='true' aria-controls='collapseOne".$count."'>
               Items:
                    </button>
                    </h2>
                    <div id='collapseOne".$count."' class='accordion-collapse collapse' data-bs-parent='#itemsAccordion". $count ."'>";
            while ($item_row = $items_result->fetch_assoc()) {
              
                echo"<div class='accordion-body'>
                                <strong> Product: $item_row[pname]</strong>
                                <br>
                                <strong> Price: $item_row[price]</strong>
                                <br>
                                <code> Quantity: $item_row[quantity] </code>
                        </div>";
                
            }
            echo "</div></div> </div>";
            
        
        }

        // Form to update order status
        echo "<form  action='update_orders_status.php' method='post'>";
        echo "<input type='hidden' name='order_id' value='" . $row["order_id"] . "'>";
        echo "<label for='status'>Update Status:</label>";
        echo "<select class='form-control mt-2' name='status' id='status'>";
        echo "<option value='pending'" . ($row["status"] == "pending" ? " selected" : "") . ">Pending</option>";
        echo "<option value='completed'" . ($row["status"] == "completed" ? " selected" : "") . ">Completed</option>";
        echo "<option value='cancelled'" . ($row["status"] == "cancelled" ? " selected" : "") . ">Cancelled</option>";
        echo "<option value='enroute'" . ($row["status"] == "cancelled" ? " selected" : "") . ">EnRoute</option>";
        echo "</select>";
        echo "  <div class='btn-group'>
                    <input type='submit' class='btn btn-sm btn-outline-danger mt-2' value='Update'>
                </div>
                ";
        echo "</form>";
        echo "</div></div></div>";

    }
    echo "</div></div></div>";
} else {
    echo "No orders found.";
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


