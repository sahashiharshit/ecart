

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        html,
body {
  height: 100%;
  background-color: aliceblue;
}

.form-signin {
  max-width: 500px;
  padding: 1rem;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.action{
            display: flex;
            margin-top:10px;
            justify-content:space-between;
        }
    </style>
    <title>Login </title>
</head>
<body>

<main class="d-flex form-signin justify-content-center w-100 m-auto align-items-center vh-100" >

        
        <form action="login.php" method="post"  >
            <h3 class="h3 mb-3 fw-normal">Enter Credentials to login</h3>
            <div class="form-floating mb-3 ">
                
                <input required type="text" class="form-control " id="username" name="username" placeholder="Username" >
                <label for="username" >User Name</label>
            </div>
            <div class="form-floating mb-3">
               
                <input required type="password" class="form-control" id="password" name="password" placeholder="password">
                <label for="password"  >Password</label>
            </div>
            
            <div class="action">
                <button class="btn btn-success"> Login </button>
                <a href="signup.html" >Sign Up here......</a>
            </div>   
            
        </form>
</main>


    
</body>
</html>


<?php
session_start();

if (isset($_SESSION['user_id']) && $_SESSION['usertype'] === 'vendor' ) {
    // Redirect to the homepage or dashboard

    header("Location: ../vendor/home.php");
    exit;
}
elseif(isset($_SESSION['user_id']) && $_SESSION['usertype'] === 'customer'){
    header("Location: ../customer/home.php");
    exit;
}


if($_SERVER["REQUEST_METHOD"]=="POST"){
    include_once('connection.php');
    //Start a new Session


    //check if csrf_token
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $_SESSION['loginStatus'] = false;
    $password = $_POST['password'];
    //database check
    $query = "select * from user where username = '$_POST[username]'";

    $sql_result = mysqli_query($connection, $query);

    $result = mysqli_fetch_assoc($sql_result);
    //password verifying
    if(password_verify($password,$result['password'])){
    
        if($result['usertype'] == 'vendor'){
            $_SESSION['loginStatus'] = true;
            $_SESSION['usertype'] = $result['usertype'];
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['username'] = $result['username'];       
            header('location:../vendor/home.php');

        }else if($result['usertype'] == 'customer'){
            $_SESSION['loginStatus'] = true;
            $_SESSION['usertype'] = $result['usertype'];
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['username'] = $result['username'];
            header('location:../customer/home.php');
        }


    }else{
        header('location:login.php');
    
    }

}else
{
    exit;
}


?>


