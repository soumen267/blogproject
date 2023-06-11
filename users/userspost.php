<?php
session_start();
include_once "maincontroller.php";
$obj = new maincontroller();
if(isset($_REQUEST['edit'])){
    $id = $_REQUEST['edit'];
    $result = $obj->fetchPostsByID('tbl_posts',$id);

    foreach($result as $row){
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $created_at =  $row['created_at'];
        $post_content = $row['post_content'];
        $post_image = $row['post_image'];
    }
}
global $username,$userid;
if(ISSET($_SESSION['name'])){
    $username = $_SESSION['name'];
}

if(isset($_POST['comment'])){
    $userid = $obj->getUserID('tbl_users',$username);
    $insertData = array(
        'post_id' => mysqli_real_escape_string($obj->conn, $_POST['post_id']),
        'comment_content' => mysqli_real_escape_string($obj->conn, $_POST['comment_content']),
        'user_id' => mysqli_real_escape_string($obj->conn, $userid)
    );
    $result = $obj->addComment('tbl_comments', $insertData);
    header("Location: ");
}
if(isset($_REQUEST['edit'])){
    $id = $_REQUEST['edit'];
    $result1 = $obj->fetchCommentsByPostID('tbl_comments','tbl_posts',$id);
}


// if(isset($_REQUEST['edit'])){
//    $id = $_REQUEST['edit'];
//    $result2 = $obj->canEditComment('tbl_posts',$userid,$id);
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Post - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <?php include_once "include/header.php"?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $post_title ;?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#"><?php echo $post_author;?></a>
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
                <p class="lead"><?php echo $post_content;?></p>
                

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post" action="<?php $_SERVER['PHP_SELF']?>">
                        <input type="hidden" name="post_id" value="<?php echo $row['id'];?>">
                        <div class="form-group">
                        <textarea name="comment_content" id="summernote" class="form-control" rows="3" placeholder="Post Content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="comment">Submit</button>
                    </form>
                </div>
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
                            </small>
                        </h4>
                        <?php echo $row['comment_content'];?>
                    </div>
                </div>
                <?php }}else{?>
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

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
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
                        </div>
                        <div class="col-lg-6">
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
        <?php include_once "include/footer.php"?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#summernote').summernote();
        })
    </script>

</body>

</html>
