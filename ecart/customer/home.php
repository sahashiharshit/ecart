<?php
session_start();

if(!isset($_SESSION['loginStatus'])){
    echo " Access Forbidden 403";
    die;
}
if($_SESSION['loginStatus'] = false){
    echo "Unauthrized Access 403";
    die;

}

if($_SESSION['usertype']=='vendor'){  
    echo "Unauthrized Access 403";
    die;
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumer Home</title>
</head>
<body>
    <h1>Consumer View</h1>
</body>
</html>