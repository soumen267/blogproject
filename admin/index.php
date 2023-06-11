<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
include "userController.php";
$obj = new userController();
global $error;
if(ISSET($_POST['submit'])){
        
        $username = mysqli_real_escape_string($obj->conn, $_POST['username']);
        $password = mysqli_real_escape_string($obj->conn, $_POST['password']);

    if($username == '' || $password == ''){
        $error = 'Username and Password is required.';
    }else{
        
        $auth = $obj->login('tbl_users', $username, $password);
        if(!$auth){
            $error = 'Invalid username or password';
            header('location:http://localhost/blogproject/blogproject/admin/');
        }
        else{
                $auth1 = $obj->isAdmin('tbl_users', $username);
                if($auth1 != TRUE){
                    $error = 'Only admin can login';
                }elseif($auth1){
                    session_start();
                    $_SESSION['name'] = $username;
                    header('location:dashboard.php');
                }
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="css/style.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
</head>
<body>
    <div id="login">
        <!-- <h3 class="text-center text-white pt-5">Login form</h3> -->
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <p class="error text-danger"><?php echo $error; ?></p>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="Submit">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="register.php" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>