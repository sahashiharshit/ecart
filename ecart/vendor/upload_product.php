<?php
require 'authgaurd.php';
include_once('../shared/connection.php');
$filePath = $_FILES['imgpath']['tmp_name'];
$uploaddir = '../shared/images/';
$uploadfile = $uploaddir.basename($_FILES['imgpath']['name']);

$query = "insert into product (pname,price,details,imgpath,owner) values('$_POST[pname]',$_POST[price],'$_POST[pro_details]','$uploadfile',$_SESSION[user_id] )";


$status = mysqli_query($connection,$query);
if($status){
    move_uploaded_file($filePath,$uploadfile);
   
    echo "<h2>Product uploaded Sucessfully. You will be redirect to upload page in 2 seconds.</h2>";
   header('Refresh: 2; URL=home.php');

}else{
    echo"<h2>Product upload unsucessfull. Error! You will be redirect to upload page in 5 seconds. </h2>";
}



?>
