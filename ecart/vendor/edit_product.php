<?php

include 'authgaurd.php';

include_once('../shared/connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['usertype'] != 'vendor') {
    header('Location: ..shared/login.php'); // Redirect to login page if not logged in as vendor
    exit();
}

if (!isset($_GET['pid'])) {
    echo "Product ID is required.";
    exit();
}

$pid = $_GET['pid'];

$sql = "SELECT * FROM product WHERE pid='$pid' AND owner='" . $_SESSION['user_id'] . "'";

 $result = $connection->query($sql);

if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        //print_r($product);
} else {
    echo "No product found or you don't have permission to edit this product.";
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['pname'];
    $price = $_POST['price'];
    $detail = $_POST['details'];
    
    // Handle image upload
    if ($_FILES["imgpath"]["name"]) {
        $impath = '../shared/images/' . basename($_FILES["imgpath"]["name"]);
        move_uploaded_file($_FILES["imgpath"]["tmp_name"], $impath);
        $sql = "UPDATE product SET pname='$name', price='$price', details='$detail', imgpath='$impath' WHERE pid='$pid' AND owner='" . $_SESSION['user_id'] . "'";
    } else {
        $sql = "UPDATE product SET pname='$name', price='$price', details='$detail' WHERE pid='$pid' AND owner='" . $_SESSION['user_id'] . "'";
    }

    if ($connection->query($sql) === TRUE) {
        header('Location: view_product.php'); // Redirect to manage products page after update
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous"> 
    <title>Edit Product</title>
</head>
<body>

<h1>Edit Product</h1>
<form method="post" enctype="multipart/form-data">
    Name: <input type="text" name="pname" value="<?php echo $product['pname']; ?>"><br>
    Price: <input type="text" name="price" value="<?php echo $product['price']; ?>"><br>
    Detail: <textarea name="details"><?php echo $product['details']; ?></textarea><br>
    Image: <input type="file" name="imgpath"><br>
    <input type="submit" value="Update Product">
</form>    
</body>
</html>
