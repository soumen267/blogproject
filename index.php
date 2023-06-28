<?php

session_start();
require_once "maincontroller.php";

$obj = new maincontroller();

$check = $obj->customQuery('tbl_posts','post_status');

$result = $obj->fetchAllData("tbl_category");
$posts = $obj->fetchAllPostData("tbl_posts");
$username = $obj->loggedinUsername();
$userrole = $obj->loggedInUserRole('tbl_users',$username);
if(isset($_POST['login'])){
  $uname = $_POST['username'];
  $upwd = $_POST['password'];
  if($uname == '' || $upwd == '')
  {
    $error = 'Username and password both is required';
  }else{
    $result = $obj->login('tbl_users', 'users', $uname, $upwd);
    if($result == TRUE){
        session_start();
        $_SESSION['uname'] = $uname;
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
    }else{
        $error = 'Invalid username or password';
    	header("Location: ");
    }
  }
    
}

if(isset($_POST['logout'])){
    $obj->logout();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "include/header.php"?>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>

    <!-- Navigation -->
    <?php include "include/navigation.php"?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
                <!-- <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <!-- First Blog Post -->
                <?php
                if($posts){
                foreach ($posts as $row){?>
                <h2>
                    <a href="userspost.php?edit=<?php echo $row['id'];?>"><?php echo ucfirst($row['post_title']) ;?></a>
                </h2>
                <p class="lead">
                    by <a href="userspost.php?edit=<?php echo $row['id'];?>"><?php echo ucfirst($row['post_author']) ;?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span>
                <?php
                $text = $row['created_at'];
                $dd = explode(" ",$text);
                echo "Posted on " .date("F j, Y", strtotime($dd[0])) ." at ". date('H:m A', strtotime($dd[1]));
                ?>
                </p>
                <hr>
                <img class="img-responsive" src="admin/images/posts/<?php echo $row['post_image']; ?>" alt="Post Image">
                <hr>
                <p><?php echo substr($row['post_content'], 0, 400);?>
                <a class="btn btn-primary" href="userspost.php?edit=<?php echo $row['id'];?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                </p>
                <hr>
                <?php }} ?>
                <!-- Pager -->
                <!-- <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul> -->

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Login -->
                <?php if(isset($_SESSION['uname'])){?>
                <div class="well">
                    <form action="" method="post">
                    <button class="btn btn-primary" type="submit" name="logout">Logout</button>
                    </form>
                </div>
                <?php }else{?>
                <div class="well">
                    <?php if(isset($error)){?>
                        <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">x</button>
                            <?php echo $error; ?>
                        </div>
                    <?php }?>
                    <h4>Login</h4>
                    <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <button class="btn btn-primary" type="submit" name="login">Submit</button>
                    </form>
                    <!-- /.input-group -->
                    <br/>
                    <a href="forgotpassword.php" class="href">Forgot Password</a>
                    <a href="register.php" class="pull-right">Register</a>
                </div>
                <?php } ?>
                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <?php if($result) {foreach($result as $row){?>
                                    <li><a href="<?php echo $row['id'];?>"><?php echo $row['cat_name'];?></a></li>
                                <?php }}?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "include/footer.php" ?>

    </div>
    <!-- /.container -->
    <?php include "include/extrajs.php" ?>
    

</body>

</html>
