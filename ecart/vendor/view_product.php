<?php 
require 'authgaurd.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous"> 
    <link rel="stylesheet" href="../shared/css/view_orders.css">
    <style>
        
        .price{
            font-size: 28px;
            font-family: cursive;
            color: chartreuse;
        }
        .price::after{
            content: 'Rs';
            font-size: 16px;
        }
        img{
            width: 200px;
            height: 200px;
        }
        .action{
            display: flex;
            margin-top:10px;
            justify-content:space-between;
        }
        .col-sm-6{
            margin-top:20px;
        }
        .row{
            margin:20px;
        }

        #hide {
            display: inline-block;
            max-width: 0%;
            vertical-align: bottom;
            overflow: hidden;
            white-space: nowrap;
            transition: max-width 1s ease-in-out;
        }

        p{
            cursor: default;
            font-size: 18px;

        }

        p:hover #hide {
            max-width: 100%;
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
            <a class="nav-link" href="manage_orders.php">Manage Orders</a>
        </li>
    </ul>
    <?php echo"<a class='navbar-brand'> Welcome $_SESSION[username]</a>"; ?>
    

   
    <form action="../shared/logout.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button class=" btn btn-danger" type="submit">Logout</button>
    </form>
    </div>

    </nav>
    <?php require '../shared/connection.php';

        $query = "select * from product where owner = '$_SESSION[user_id]'";

        $result = mysqli_query($connection,$query);
    ?>
        
        <div class='container-fluid bg-trasparent my-4 p-3' style='position: relative;'>
        <div class='row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3'>
                <?php while($dbrow = mysqli_fetch_assoc($result)){ ?>
                <div class="col">
                    <div class = "card h-100 shadow-sm" style='background-color:lavender'>
                    <img class="card-img-top" src="<?php echo $dbrow["imgpath"];?>">
                        <div class = "card-body">
                        <div class='clearfix mb-3'>
                             <span class='float-start badge rounded-pill bg-primary'><?php echo $dbrow["pname"];?></span>
                              <span class='float-end price-hp'><?php echo $dbrow["price"];?>&#8377;</span>
                            </div>
                            <h6 class="card-title">
                                <?php echo $dbrow["details"];?>
                            </h6>
                           
                            <div class="action">
                                <a href="edit_product.php?pid=<?php echo $dbrow["pid"]; ?>"><button class='btn btn-outline-secondary' >Edit</button></a>
                                <a href="remove_product.php?pid=<?php echo $dbrow["pid"]; ?>" onclick="return confirm('Are you sure?');"><button class='btn btn-outline-info'>Remove</button></a>
                            </div>
                        </div>            
                    </div>
                </div>    
            <?php  } ?>
            </div>
        </div>

</body>
</html>



