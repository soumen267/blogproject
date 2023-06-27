<?php
session_start();
include_once "../maincontroller.php";
$obj = new maincontroller();
//login

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

if(isset($_REQUEST['edit'])){
    $id = $_REQUEST['edit'];
    $result = $obj->fetchPostsByID('tbl_posts','tbl_category',$id);

    foreach($result as $row){
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $created_at =  $row['created_at'];
        $post_content = $row['post_content'];
        $post_image = $row['post_image'];
    }
}
global $username,$userid,$adm;
if(ISSET($_SESSION['uname'])){
    $username = $_SESSION['uname'];
}

if(isset($_POST['comment'])){
    $userid = $obj->loggedinUserId();
    $insertData = array(
        'post_id' => mysqli_real_escape_string($obj->conn, $_POST['post_id']),
        'comment_content' => mysqli_real_escape_string($obj->conn, $_POST['comment_content']),
        'user_id' => mysqli_real_escape_string($obj->conn, $userid)
    );
    $result = $obj->insertData('tbl_comments', $insertData);
    header("Location: ");
}
if(isset($_REQUEST['edit'])){
    $id = $_REQUEST['edit'];
    $result1 = $obj->fetchCommentsByPostID('tbl_comments','tbl_posts',$id);
}
$adm = 0;
if(isset($_GET['adm'])){
    $adm = 1;
}
$uid = $obj->loggedinUserId();
if(isset($_POST['commentid'])){
    $id = $_REQUEST['edit'];
    $result2 = $obj->fetchCommentsByPostID('tbl_comments','tbl_posts',$id);
}
$getCategory = $obj->fetchAllData("tbl_category");

//Like Unlike
if(isset($_REQUEST['edit']) && $obj->isLoggedIn()){
    $id = $_REQUEST['edit'];
    $userid = $obj->loggedinUserId();
    $result3 = $obj->userUnlike($id, $userid);
}
if(isset($_POST['liked']) && $obj->isLoggedIn()){
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    $insertArray = array(
        "post_id" => mysqli_real_escape_string($obj->conn, $post_id),
        "user_id" => mysqli_real_escape_string($obj->conn, $user_id),
    );
    $obj->insertData('tbl_like', $insertArray);
    if($obj){
        echo "Inserted";
    }
    exit();
}
if(isset($_POST['unliked']) && $obj->isLoggedIn()){
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $obj->deletedataWithoutDeleteColumn('tbl_like', $post_id, $user_id);
}
if(isset($_REQUEST['edit'])){
    $id = $_REQUEST['edit'];
    $countlikes = $obj->countDataByColumn('tbl_like', 'post_id', $id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "include/header.php"?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <?php include "include/navigation.php"?>
    <?php
    
    if(!isset($_GET['adm']) && $adm != 1){?>
    <?php include_once "include/header.php"?>
    <?php } ?>
    <!-- Page Content -->
    <div class="container">

        <div class="row mydiv">

            <!-- Blog Post Content Column -->
            <?php if($adm != 1){?>
                <div class="col-lg-8">
            <?php }else{?>
                <div class="col-lg-12">
            <?php } ?>
                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $post_title ;?></h1>

                <!-- Author -->
                <p class="lead">
                    by <?php echo $post_author;?>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> <?php
                $text = $created_at;
                $dd = explode(" ",$text);
                echo "Posted on " .date("F j, Y", strtotime($dd[0])) ." at ". date('H:m A', strtotime($dd[1]));
                ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="../admin/images/posts/<?php echo $post_image; ?>" alt="">

                <hr>
                <!-- Post Content -->
                <p class="lead likes"><?php echo $post_content;?>
                <?php if($obj->isLoggedIn()){ ?>
                <a class="<?php echo $result3 == TRUE ? 'unlike' : 'like'; ?>" href="javascript:void(0)">
                <span class="glyphicon glyphicon-thumbs-<?php echo $result3 == TRUE ? 'down' : 'up'; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $result3 == TRUE ? ' I liked this before' : 'Want to like it?'; ?>"></span>
                <?php echo $result3 == TRUE ? 'Unlike' : ' Like'; ?>
                </a>
                (<?php echo $countlikes ? ''.$countlikes.'' : '0';?>)
                <?php }else{ ?>
                <div class="row">
                <p class="pull-right login-to-post">You need to <a href="javascript:void(0)" class="scroll">Login</a> to like </p>
                </div>
                <?php } ?>
                </p>                
                <?php if($adm != 1 && empty($adm)){?>
                <hr>
                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post" action="<?php $_SERVER['PHP_SELF']?>">
                        <input type="hidden" name="post_id" value="<?php echo $row['id'];?>">
                        <div class="form-group">
                        <input type="text" name="author" id="author" class="form-control" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email address">
                        </div>
                        <div class="form-group">
                        <textarea name="comment_content" class="form-control" rows="3" placeholder="Post Content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="comment">Submit</button>
                    </form>
                </div>
                <?php }?>
                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php
                if(!empty($result1)){
                foreach($result1 as $row){?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="../admin/images/posts/<?php echo $post_image; ?>" alt="Image" style="height:28px;width:71px;">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $post_title; ?>
                            <small><?php
                                $text = $row['created_at'];
                                $dd = explode(" ",$text);
                                echo (date("F j, Y", strtotime($dd[0])) ." at ". date('H:m A', strtotime($dd[1])));
                                ?>
                            <?php if($uid == $row['id']){?>
                                <button data-id="<?php echo $row['id'];?>" class="btn-primary editbtn" type="button">Edit</button>
                            <?php }?>
                            </small>
                        </h4>
                        <?php echo $row['comment_content'];?>
                    </div>
                </div>
                <?php }} else {?>
                <p>This post has no comments.</p>
                <?php }?>
                <!-- Comment -->
                <!-- <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        Nested Comment
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        End Nested Comment
                    </div>
                </div> -->

            </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php if($adm != 1 && empty($adm)){?>
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well logindiv">
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
                                <?php if($getCategory) {foreach($getCategory as $row){?>
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
            <?php }?>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include_once "include/footer.php"?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <?php include "include/extrajs.php" ?>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#summernote').summernote();
        })
        $(".editbtn").click(function(){
            var sesval = "<?php echo $username;?>";
            if(!sesval){
                alert("Please Login before edit your comment!");
            }
        })
        $(document).ready(function(){
            $("[data-toggle='tooltip']").tooltip();
            var post_id = "<?php echo $_GET['edit']; ?>";
            var user_id = "<?php echo $obj->loggedinUserId(); ?>";
            $('.like').click(function(){
                    $.ajax({
                        url: "userspost.php?edit=<?php echo $_GET['edit']; ?>",
                        type: 'post',
                        data: {
                            'liked': 1,
                            'post_id': post_id,
                            'user_id': user_id
                        },
                        success:function(data){
                            location.reload();
                            console.log(data)
                        }
                    });
            });

            $('.unlike').click(function(){
                $.ajax({
                    url: "userspost.php?edit=<?php echo $_GET['edit']; ?>",
                    type: 'post',
                    data: {
                        'unliked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    },
                    success:function(data){
                        location.reload();
                        console.log(data)
                    }
                });
                });
            })
    $(".scroll").on("click", function(){
        window.scrollTo({
        top: 0,
        behavior: "smooth"
        });
    });
 </script>
</body>

</html>
