<?php
session_start();
require_once "../maincontroller.php";

$obj = new maincontroller();
if(ISSET($_GET['edit'])){
    $id = $_GET['edit'];
    $result = $obj->fetchDataByID('tbl_users', 'user_id', $id);
    foreach($result as $row){
        $post_id = $row['user_id'];
        $username = $row['username'];
        $password = $row['password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
        $user_image = $row['user_image'];
    }
}
//Update

global $nameerr,$passerr,$ferr,$lerr,$emailerr,$roleerr,$imageerr;
$err = 0;
if (isset($_POST['updateuser'])) {
    $id = $_POST['id'];
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
     if($err != 1 && isset($_FILES['user_image']['name']) == true && $_FILES['user_image']['name']){
        $id = $_POST['id'];
        $filename2 = $post_image;
        $filename = $_FILES['user_image']['name'];
        $tmpname = $_FILES['user_image']['tmp_name'];
        // $filesize = $_FILES['user_image']['size'];
        // $filetype = $_FILES['user_image']['type'];
        // $error = $_FILES['user_image']['error'];
        $image_type = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $filename1 = strtolower(pathinfo($filename, PATHINFO_FILENAME));
        $fileInfo = pathinfo($filename);
        $ipath = uniqid() . '.' . $fileInfo['extension'];
        $allow_type = array('jpeg','jpg');
        if(in_array($image_type, $allow_type))
        {
            if(file_exists("./images/users/".$filename2)){
                unlink("./images/users/".$filename2);
                move_uploaded_file($tmpname, "./images/users/".$ipath);
            }else{
                move_uploaded_file($tmpname, "./images/users/".$ipath);
            }
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
            $obj->updateData('tbl_users', $insertData, 'user_id', $id);
            $_SESSION['msg'] = 'User edited successfully.';
            header("location: http://localhost/blogproject/admin/users.php");
            exit();
        }else{
            $imageerr = "Only jpeg file is allowed!";
        }
    }elseif(ISSET($_POST['updateuser'])){
        $insertData = array(
            'username' => mysqli_real_escape_string($obj->conn, $_POST['username']),
            'password' => mysqli_real_escape_string($obj->conn, $_POST['password']),
            'user_firstname' => mysqli_real_escape_string($obj->conn, $_POST['user_firstname']),
            'user_lastname' => mysqli_real_escape_string($obj->conn, $_POST['user_lastname']),
            'user_email' => mysqli_real_escape_string($obj->conn, $_POST['user_email']),
            'user_role' => mysqli_real_escape_string($obj->conn, $_POST['user_role']),
        );
        $obj->updateData('tbl_users', $insertData, 'user_id', $id);
        $_SESSION['msg'] = 'User edited successfully.';
        header("location: http://localhost/blogproject/admin/users.php");
        exit();
    }
    
}



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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
                            Edit User
                            <small>Subheading</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                    
                </div>
                <!-- /.row --> 
                <div class="row">
                
                <div class="col-lg-12">
                <form action="" method="POST" class="" role="form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $post_id;?>">
                            <div class="form-group">
                                <label class="" for="">Username</label>
                                <input type="text" class="form-control" name="username" id="" value="<?php echo $username; ?>" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Password</label>
                                <input type="password" class="form-control" name="password" id="" value="<?php echo $password; ?>" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Firstname</label>
                                <input type="text" class="form-control" name="user_firstname" id="" value="<?php echo $user_firstname; ?>" placeholder="Firstname">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Lastname</label>
                                <input type="text" class="form-control" name="user_lastname" id="" value="<?php echo $user_lastname; ?>" placeholder="Lastname">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Email</label>
                                <input type="email" class="form-control" name="user_email" id="" value="<?php echo $user_email; ?>" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Role</label>
                                <select name="user_role" id="input" class="form-control">
                                    <option value="">Select</option>
                                    <option <?php if($user_role == 'admin'){echo 'selected';}?> value="admin">Admin</option>
                                    <option <?php if($user_role == 'user'){echo 'selected';}?> value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Image</label>
                                <input type="file" class="form-control" name="user_image" id="" value="<?php echo $user_image; ?>" placeholder="Image">
                                <img src="./images/users/<?php echo $user_image;?>" class="img-responsive" style="height:42px;width:71px;" alt="Image">
                            </div>
                            <button type="submit" name="updateuser" class="btn btn-primary">Submit</button>
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
</body>

</html>