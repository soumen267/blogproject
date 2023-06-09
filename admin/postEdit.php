<?php
require_once "postController.php";

$obj = new postController();
if(ISSET($_GET['edit'])){
    $id = $_GET['edit'];
    $result = $obj->fetchPostsByID('tbl_posts', 'tbl_category', $id);
    foreach($result as $row){
        $fid = $row['fid'];
        $post_id = $row['id'];
        $post_title = $row['post_title'];
        $post_author = $row['post_author'];
        $post_user = $row['post_user'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_status = $row['post_status'];
        $post_content = $row['post_content'];
    }
}
$result1 = $obj->fetchByCategory('tbl_category');
if(ISSET($_POST['updatepost'])){
        $id = $_POST['id'];
        $date = date('Y-m-d');
        $insertData = array(
            'post_cat_id' => mysqli_real_escape_string($obj->conn, $_POST['post_cat_id']),
            'post_title' => mysqli_real_escape_string($obj->conn, $_POST['post_title']),
            'post_author' => mysqli_real_escape_string($obj->conn, $_POST['post_author']),
            'post_user' => mysqli_real_escape_string($obj->conn, $_POST['post_user']),
            'post_date' => mysqli_real_escape_string($obj->conn, $date),
            'post_image' => mysqli_real_escape_string($obj->conn, $_FILES['post_image']['name']),
            'post_content' => mysqli_real_escape_string($obj->conn, $_POST['post_content']),
            'post_tag' => mysqli_real_escape_string($obj->conn, $_POST['post_tag']),
            'post_comment_count' => '0',
            'post_status' => mysqli_real_escape_string($obj->conn, $_POST['post_status']),
            'post_view_count' => '0',
        );
        // print_r($insertData);
        // die;
    $obj->updatePostData('tbl_posts', $insertData, $id);
    header("location: http://localhost/blogproject/admin/post.php");
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
                            Posts
                            <small>Subheading</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="active">
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
                                <label class="" for="">Category Name</label>
                                <select name="post_cat_id" id="input" class="form-control">
                                    <option value="">Select</option>
                                    <?php foreach ($result1 as $row) { ?>
                                        <option <?php if ($row['id'] === $fid) { ?> selected="selected" <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['cat_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Title</label>
                                <input type="text" class="form-control" name="post_title" id="" value="<?php echo $post_title; ?>" placeholder="Post Title">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Author</label>
                                <input type="text" class="form-control" name="post_author" id="" value="<?php echo $post_author; ?>" placeholder="Post Author">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post User</label>
                                <input type="text" class="form-control" name="post_user" id="" value="<?php echo $post_user; ?>" placeholder="Post User">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Image</label>
                                <input type="file" class="form-control" name="post_image" id="" value="<?php echo $post_image; ?>" placeholder="Image">
                                <img src="./images/posts/<?php echo $post_image;?>" class="img-responsive" style="height:42px;width:71px;" alt="Image">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Tag</label>
                                <input type="text" class="form-control" name="post_tag" id="" value="<?php echo $post_tag; ?>" placeholder="Post Tag">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Status</label>
                                <input type="text" class="form-control" name="post_status" id="" value="<?php echo $post_status; ?>" placeholder="Post Status">
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Content</label>
                                <textarea name="post_content" id="summernote" class="form-control" rows="3" placeholder="Post Content"><?php echo htmlentities($post_content); ?></textarea>
                            </div>
                            <button type="submit" name="updatepost" class="btn btn-primary">Submit</button>
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
    <script>
        $(document).ready(function(){
            $('#summernote').summernote();
        })
    </script>

</body>

</html>