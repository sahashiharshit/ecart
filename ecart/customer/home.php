<?php
require 'customer_authgaurd.php';
require '../shared/connection.php';
$query = "select * from product";
$result = mysqli_query($connection, $query);
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
    <title>Consumer Home</title>
    <style>
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
            height: 200px;
        }

        .col-sm-6 {
            margin-top: 20px;
        }

        .row {
            margin: 20px;
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

        .action {
            display: flex;
            margin-top: 10px;
            justify-content: space-between;
        }
    </style>

</head>

<body>
    <!-- Navbar code starts here -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ecart</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="cart_view.php">View Cart</a>
                </li>
                <li>
                    <a class="nav-link " href="view_orders.php">My Orders</a>
                </li>
            </ul>
            <?php echo "<a class='navbar-brand'> Welcome $_SESSION[username]</a>"; ?>

            <form action="../shared/logout.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <button class=" btn btn-danger" type="submit">Logout</button>
            </form>
        </div>
    </nav>
    <!-- navbar code ends here-->
    <main>
        <div class="container-fluid bg-transparent my-4 p-3" style="position: relative">
            <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
                <?php while ($dbrow = mysqli_fetch_assoc($result)) { ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm" style="background-color:lavender">
                            <img src="<?php echo $dbrow["imgpath"]; ?>" class="card-img-top">
                            <div class="card-body">
                                <div class='clearfix mb-3'>
                                    <span
                                        class='float-start badge rounded-pill bg-primary'><?php echo $dbrow["pname"]; ?></span>
                                    <span class='float-end price-hp'><?php echo $dbrow["price"]; ?>&#8377;</span>
                                </div>
                                <h5 class="card-title"><?php echo $dbrow["details"] ?></h5>

                                <div class=" row g-3">
                                    <form action="add_cart.php" method="post">

                                        <div class="col">
                                            <input type="hidden" id="pid" name="pid" value="<?php echo $dbrow['pid']; ?>">
                                            <label for='quantity' class="form-label">Quantity:</label>
                                            <input type="number" class="form-control" name="quantity" id="quantity" min="1"
                                                max="10" value="1">
                                        </div>
                                        <div class="row">
                                            <button class='btn form-control' style="background-color:palegreen">
                                                <i class="bi bi-cart-plus"
                                                    style="font-size: 1.5rem; color: cornflowerblue;"> Cart</i>
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

</body>

</html>