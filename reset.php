<?php
session_start();
include_once "maincontroller.php";
$obj = new maincontroller();
    if(!isset($_SESSION['email'])){
        header("Location: http://localhost/blogproject/users/");
    }
if(isset($_POST['resetPassword']))
{
    if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
        if($_POST['password'] === $_POST['confirmPassword']){
            $password = $_POST['password'];
            $email = $_SESSION['email'];
            $inputData = array(
                'password' => mysqli_real_escape_string($obj->conn, $_POST['password'])
            );
            //$hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
            $obj->updatedData('tbl_users', $inputData, 'user_email', $email);
            unset($email);
            header("Location: http://localhost/blogproject/users/");
        }

    }
}

?>
<!-- Navigation -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="./users/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
  <link href="./users/css/blog-post.css" rel="stylesheet">
</head>
<body>
<?php include "./users/include/header.php"; ?>

<div class="container">



    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">


                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<hr>
</div> <!-- /.container -->
</body>
</html>