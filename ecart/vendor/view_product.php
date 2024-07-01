<?php 
include 'authgaurd.php';
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
          <a class="nav-link active" aria-current="page" href="home.php">Upload Product</a>
        </li>
    </ul>
    <?php echo"<a class='navbar-brand'> Welcome $_SESSION[username]</a>"; ?>
    

   
    <form action="../shared/logout.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button class=" btn btn-danger" type="submit">Logout</button>
    </form>
    </div>

    </nav>
    <?php include_once('../shared/connection.php');

        $query = "select * from product where owner = '$_SESSION[user_id]'";

        $result = mysqli_query($connection,$query);
    ?>
        
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php while($dbrow = mysqli_fetch_assoc($result)){ ?>
                <div class="col">
                    <div class = "card">
                        <div class = "card-body">
                            <img src="<?php echo $dbrow["imgpath"];?>">
                            <div class="card-title"><?php echo $dbrow["pname"];?></div>
                            <div class="card-sub-title price"><?php echo $dbrow["price"];?></div>
                            <div>
                                <p>Description... <span id ="hide"><?php echo $dbrow["details"];?> </span></p>
                            </div>
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



