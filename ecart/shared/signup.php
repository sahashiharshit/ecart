<?php

include_once('connection.php');

$password = password_hash($_POST['password'],PASSWORD_BCRYPT);

$query = "insert into user(username,password,usertype) values('$_POST[username]','$password','$_POST[usertype]')";

$status = mysqli_query($connection,$query);

?>