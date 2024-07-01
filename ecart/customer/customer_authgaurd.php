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