<?php
include 'authgaurd.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">   

    <title>Vendor Dashboard</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class = "container-fluid">
    <a class="navbar-brand" href="#">Vendor Dashboard</a>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="view_product.php">View Inventory</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="manage_orders.php"> Manage Orders</a>
        </li>
    </ul>
    <?php echo"<a class='navbar-brand'> Welcome $_SESSION[username]</a>"; ?>
    
    <form action="../shared/logout.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button class=" btn btn-danger" type="submit">Logout</button>
    </form>
   
    </div>

    </nav>
    


    <div class="d-flex justify-content-center align-items-center vh-100">
            
        <form action="upload_product.php" method="post" enctype="multipart/form-data" class=" p-4 w-50" >
        <h1 class="text-center">Upload Products</h1>
            <div class="mb-3">
            <label for="pname"  class="form-label">Product Name</label>
            <input type="text" name="pname" id="pname" class="form-control mt-3" required>
            </div class="mb-3">
            <div>
            <label for="price"  class="form-label">Price of Product</label>
            <input type="number" name="price" id="price" min="0" class="form-control mt-3" required>
            </div>
            <div class="mb-3">
            <label for="pro_details"  class="form-label">Enter details for product</label>
            <textarea name="pro_details" id="pro_details" cols = "30" rows ="5" class="form-control mt-3" required></textarea>
            </div>
            <div class="mb-3">
            <label for="price"  class="form-label">Upload Product Image</label>
            <input type="file" name="imgpath" id="imgpath" accept=".jpg,.png,.jpeg" class="form-control" required>

            </div>

            <div class="mb-2">
                <button class="btn btn-outline-secondary" name = "add_pro">Add Product</button>
            </div>    
        </form>

    </div>
</body>
</html>