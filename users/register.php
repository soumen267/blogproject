<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
include "../maincontroller.php";
$obj = new maincontroller();
global $nameerr,$passerr,$ferr,$lerr,$emailerr,$imageerr,$error;
$err = 0;
if (isset($_POST['register'])) {
    $pwd = $_POST['password'];
    $upper = preg_match('@[A-Z]@', $pwd);
    $lower = preg_match('@[a-z]@', $pwd);
    $number = preg_match('@[0-9]@', $pwd);
    $specialchr = preg_match('@[^\w]@', $pwd);
    $uname = $obj->usernameExists($_POST['username']);
    $uemail = $obj->emailExists($_POST['user_email']);
    if ($_POST['username'] == '' || empty($_POST['username'])) {
        $nameerr = "Username is required!";
        $err = 1;
    }elseif ($uname == TRUE){
        $nameerr = "Username is already exists";
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
    }elseif ($uemail == TRUE){
        $emailerr = "Email is already exists";
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
            move_uploaded_file($tmpname, "../admin/images/users/".$ipath);
            $date = date('Y-m-d');
            $insertData = array(
                'username' => mysqli_real_escape_string($obj->conn, $_POST['username']),
                'password' => mysqli_real_escape_string($obj->conn, $_POST['password']),
                'user_firstname' => mysqli_real_escape_string($obj->conn, $_POST['user_firstname']),
                'user_lastname' => mysqli_real_escape_string($obj->conn, $_POST['user_lastname']),
                'user_image' => mysqli_real_escape_string($obj->conn, $ipath),
                'user_email' => mysqli_real_escape_string($obj->conn, $_POST['user_email'])
            );
            $obj->insertData('tbl_users', $insertData);
            $referer = $_SERVER['HTTP_REFERER'];
            header("location: $referer");
        }else{
            $imageerr = "Only jpeg file is allowed!";
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
    <title>MyBlog</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style>
        .vertical-center {
        display: flex;
        align-items: center;
        min-height: 100vh;
        }
        .col-lg-offset-5 {
            margin-left: 35.666667%;
        }
        .col-lg-2 {
            width: 33.666667%;
        }
    </style>
</head>
<body>
    <?php include "include/navigation.php"?>
        <!-- <h3 class="text-center text-white pt-5">Login form</h3> -->
        <div class="container-fluid" style=" background-color: #17a2b8;">
            <div class="row vertical-center">
                        <form id="login-form" class="col-xs-8 col-xs-offset-2  col-sm-6 col-sm-offset-3 col-md-4 col-sm-offset-4 col-lg-2 col-lg-offset-5" action="" method="post" enctype="multipart/form-data"  style="background-color: #EAEAEA; padding:18px;border: 1px solid white;">
                            <h3 class="text-center text-info">Register</h3>
                            <p class="error text-danger"><?php echo $error; ?></p>
                            <div class="form-group">
                                <label for="username">Username:</label><br>
                                <input type="text" name="username" id="username" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : ''; ?>" class="form-control" placeholder="Username">
                                <p class="text-danger"><?php echo $nameerr ;?></p>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label><br>
                                <input type="password" name="password" id="password" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" class="form-control" placeholder="Password">
                                <p class="text-danger"><?php echo $passerr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" class="text-info">Firstname</label>
                                <input type="text" class="form-control" name="user_firstname" value="<?php echo isset($_POST["user_firstname"]) ? $_POST["user_firstname"] : ''; ?>" placeholder="Firstname">
                                <p class="text-danger"><?php echo $ferr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Lastname</label>
                                <input type="text" class="form-control" name="user_lastname" value="<?php echo isset($_POST["user_lastname"]) ? $_POST["user_lastname"] : ''; ?>" placeholder="Lastname">
                                <p class="text-danger"><?php echo $lerr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Email</label>
                                <input type="email" class="form-control" name="user_email" value="<?php echo isset($_POST["user_email"]) ? $_POST["user_email"] : ''; ?>" placeholder="Email">
                                <p class="text-danger"><?php echo $emailerr ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Image</label>
                                <input type="file" class="" name="user_image" placeholder="Image" id="image">
                                <p class="text-danger"><?php echo $imageerr ;?></p>
                            </div>
                            <div id="preview"></div>
                            <br/>
                            <button type="submit" name="register" class="btn btn-primary">Submit</button>
                            <a href="http://localhost/blogproject/users/" class="pull-right" style="font-size:20px;">Login</a>
                        </form>
                    </div>
                </div>
<script>
    function imagePreview(fileInput) {
    if (fileInput.files && fileInput.files[0]) {
        var fileReader = new FileReader();
        fileReader.onload = function (event) {
            $('#preview').html('<img src="'+event.target.result+'" width="89" height="80"/>');
        };
        fileReader.readAsDataURL(fileInput.files[0]);
    }
}
$("#image").change(function () {
    imagePreview(this);
});
</script>
</body>
</html>