<?php
require 'customer_authgaurd.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../shared/css/view_orders.css">
    <title>View Cart</title>
    <style>
        .col-sm-6 {
            margin-top: 20px;
        }

        .row {
            margin: 20px;
        }

        .price {
            font-size: 28px;
            font-family: cursive;
            color: chartreuse;
        }

        .price::after {
            content: 'Rs';
            font-size: 16px;
        }

        img {
            width: 200px;
            height: 400px;
        }

        #hide {
            display: inline-block;
            max-width: 0%;
            vertical-align: bottom;
            overflow: hidden;
            white-space: nowrap;
            transition: max-width 1s ease-in-out;
        }

        p {
            cursor: default;
            font-size: 18px;

        }

        p:hover #hide {
            max-width: 100%;
        }
    </style>
</head>

<body style="background-color:aliceblue">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ecart</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="view_orders.php">My Orders</a>
                </li>
            </ul>
            <?php echo "<a class='navbar-brand'> Welcome $_SESSION[username]</a>"; ?>



            <form action="../shared/logout.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button class=" btn btn-danger" type="submit">Logout</button>
            </form>
        </div>
    </nav>

    <?php

    require '../shared/connection.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../shared/login.php'); // Redirect to login page if not logged in
        exit();
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Fetch cart items for the logged-in user
    $sql = "SELECT cart.*, product.imgpath, product.pname, product.price FROM cart JOIN product ON cart.product_id = product.pid WHERE cart.user_id='$user_id' AND cart.status='active'";
    $result = $connection->query($sql);
    echo "<div class='container-fluid'>
 <div class='row row-cols-1 row-cols-md-4 g-4'>";
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            ?>
            <div class="col">
                <div class="card h-100 shadow-sm " style="background-color:lavender">
                    <img src="<?php echo $row['imgpath'] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <div class="card-title"><?php echo $row["pname"]; ?></div>
                        <div class="card-subtitle price"><?php echo $row["price"]; ?></div>
                        <div>
                            <p>Description... <span id="hide"><?php echo $row["details"]; ?> </span></p>
                        </div>
                        <div class="card-title">
                            Quantity: <?php echo $row['quantity']; ?>
                        </div>
                        <a href="remove_cart.php?cart_item_id=<?php echo $row['cart_item_id']; ?>">Remove</a><br><br>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
        <div class="container p-4">
            <form class="form-control p-2" action='place_order.php' method='post'>
                <label for="payment_method">Choose a Payment Method</label><br> 
                <input type="radio" name="payment_method" id="online" value="online" class="mt-3" >
                <label for="online">Online Payment</label><br>
                <input type="radio" name="payment_method" id="cod" value="cod" class="mt-3">
                <label for="cod">Cash On Delivery</label><br>
                <input type="submit" value="Pay Now" class="btn btn-outline-secondary mt-3">
            </form>
        </div>
        <?php
    } else {
        echo "Your cart is empty.";
    }

    echo "</div></div>";
    ?>



</body>

</html>