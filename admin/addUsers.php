<?php
session_start();
include "../maincontroller.php";

$obj = new maincontroller();
global $nameerr,$passerr,$ferr,$lerr,$emailerr,$roleerr,$imageerr;
$err = 0;
if (isset($_POST['submit'])) {
    $pwd = $_POST['password'];
    $upper = preg_match('@[A-Z]@', $pwd);
    $lower = preg_match('@[a-z]@', $pwd);
    $number = preg_match('@[0-9]@', $pwd);
    $specialchr = preg_match('@[^\w]@', $pwd);

    if ($_POST['username'] == '' || empty($_POST['username'])) {
        $nameerr = "Username is required!";
        $err = 1;
    }
    if($_POST['password'] == '' || empty($_POST['password'])){
        $passerr = "Password is required!";
        $err = 1;
    }elseif(!$upper ||! $lower || !$number || !$specialchr || strlen($pwd)<8){
        $passerr = "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
        $err = 1;
    }
    if($_POST['user_firstname'] == '' || empty($_POST['user_firstname'])){
        $ferr = "Firstname is required!";
        $err = 1;
    }
    if($_POST['user_lastname'] == '' || empty($_POST['user_lastname'])){
        $lerr = "Lastname is required!";
        $err = 1;
    }
    if($_POST['user_email'] == '' || empty($_POST['user_email'])){
        $emailerr = "Email is required!";
        $err = 1;
    }
    if($_POST['user_role'] == '' || empty($_POST['user_role'])){
        $roleerr = "Role is required!";
        $err = 1;
    }
     if($err != 1 && isset($_FILES['user_image'])){
        $filename = $_FILES['user_image']['name'];
        $tmpname = $_FILES['user_image']['tmp_name'];
        $filesize = $_FILES['user_image']['size'];
        $filetype = $_FILES['user_image']['type'];
        $error = $_FILES['user_image']['error'];
        $image_type = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $filename1 = strtolower(pathinfo($filename, PATHINFO_FILENAME));
        $fileInfo = pathinfo($filename);
        $ipath = uniqid() . '.' . $fileInfo['extension'];
        $allow_type = array('jpeg','jpg');
        if(in_array($image_type, $allow_type))
        {
            move_uploaded_file($tmpname, "images/users/".$ipath);
            $date = date('Y-m-d');
            $insertData = array(
                'username' => mysqli_real_escape_string($obj->conn, $_POST['username']),
                'password' => mysqli_real_escape_string($obj->conn, $_POST['password']),
                'user_firstname' => mysqli_real_escape_string($obj->conn, $_POST['user_firstname']),
                'user_lastname' => mysqli_real_escape_string($obj->conn, $_POST['user_lastname']),
                'user_image' => mysqli_real_escape_string($obj->conn, $ipath),
                'user_email' => mysqli_real_escape_string($obj->conn, $_POST['user_email']),
                'user_role' => mysqli_real_escape_string($obj->conn, $_POST['user_role']),
            );
            $obj->insertData('tbl_users', $insertData);
            header("location: http://localhost/blogproject/admin/users.php");
        }else{
            $imageerr = "Only jpeg file is allowed!";
        }
    }
    
}
//$result = $obj->fetchByCategory('tbl_category');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        .password-container{
        width: 400px;
        position: relative;
        }
        .password-container input[type="password"],
        .password-container input[type="text"]{
        width: 202%;
        padding: 4px 36px 12px 12px;
        box-sizing: border-box;
        }
        .fa-eye{
        position: absolute;
        top: 57%;
        right: -100% !important;
        cursor: pointer;
        color: lightgray;
        }
    </style>
</head>

<body>
    <?php include "include/header.php"; ?>
    <div id="wrapper">



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add Users
                            <small>Subheading</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>

                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-8">
                        <form action="" method="POST" class="" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="" for="">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username">
                                <p class="text-danger"><?php echo $nameerr ;?></p>
                            </div>
                            <div class="form-group password-container">
                                <label class="" for="">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" minlength="8">
                                <i class="fa-solid fa-eye" id="eye"></i>
                                <p class="text-danger"><?php echo $passerr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Firstname</label>
                                <input type="text" class="form-control" name="user_firstname" placeholder="Firstname">
                                <p class="text-danger"><?php echo $ferr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Lastname</label>
                                <input type="text" class="form-control" name="user_lastname" placeholder="Lastname">
                                <p class="text-danger"><?php echo $lerr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Email</label>
                                <input type="email" class="form-control" name="user_email" placeholder="Email">
                                <p class="text-danger"><?php echo $emailerr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Role</label>
                                <select name="user_role" id="input" class="form-control" required="required">
                                    <option value="">Select</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <p class="text-danger"><?php echo $roleerr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Image</label>
                                <input type="file" class="form-control" name="user_image" placeholder="Image">
                                <p class="text-danger"><?php echo $imageerr ;?></p>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <?php include "include/footer.php" ?>
        <script type="text/javascript">
        const pwd = document.querySelector("#password");
        const eye = document.querySelector("#eye");
        if(eye){
            eye.addEventListener("click", function(){
            this.classList.toggle("fa-eye-slash")
            const type = pwd.getAttribute("type") === "password" ? "text" : "password"
            pwd.setAttribute("type", type)
        })
        }
    </script>
</body>
</html>