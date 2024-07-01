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
    // Delete the product
    $delete_sql = "DELETE FROM product WHERE pid='$pid' AND owner='" . $_SESSION['user_id'] . "'";
    if ($connection->query($delete_sql) === TRUE) {
        header('Location: view_product.php'); // Redirect to manage products page after deletion
        exit();
    } else {
        echo "Error: " . $delete_sql . "<br>" . $connection->error;
    }
} else {
    echo "No product found or you don't have permission to delete this product.";
}
?>