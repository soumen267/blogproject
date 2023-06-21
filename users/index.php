<?php
session_start();
require_once "../maincontroller.php";

$obj = new maincontroller();

$result = $obj->fetchAllData("tbl_category");

$posts = $obj->fetchAllData("tbl_posts");
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
        header("Location: http://localhost/blogproject/users/");
        exit;
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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Home - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-home.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <?php include "include/header.php"?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

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
                <img class="img-responsive" src="../admin/images/posts/<?php echo $row['post_image']; ?>" alt="Post Image">
                <hr>
                <p><?php echo $row['post_content'];?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php }} ?>
                <!-- Second Blog Post -->
                <!-- <h2>
                    <a href="#">Blog Post Title</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">Start Bootstrap</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 28, 2013 at 10:45 PM</p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, quasi, fugiat, asperiores harum voluptatum tenetur a possimus nesciunt quod accusamus saepe tempora ipsam distinctio minima dolorum perferendis labore impedit voluptates!</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr> -->

                <!-- Third Blog Post -->
                <!-- <h2>
                    <a href="#">Blog Post Title</a>
                </h2>
                <p class="lead">
                    by <a href="index.php">Start Bootstrap</a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on August 28, 2013 at 10:45 PM</p>
                <hr>
                <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, voluptates, voluptas dolore ipsam cumque quam veniam accusantium laudantium adipisci architecto itaque dicta aperiam maiores provident id incidunt autem. Magni, ratione.</p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr> -->

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

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
                    <a href="../forgotpassword.php" class="href">Forgot Password</a>
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
                        <!-- /.col-lg-6 -->
                        <!-- <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                                <li><a href="#">Category Name</a>
                                </li>
                            </ul>
                        </div> -->
                        <!-- /.col-lg-6 -->
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
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website <?php echo date("Y");?></p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
