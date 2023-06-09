<?php
require_once "../maincontroller.php";
session_start();
$obj = new maincontroller();
global $cateerrors, $titleerrors, $authorerrors,$usererrors,$contenterrors,$tagerrors,$statuserrors;
$err = 0;
if (isset($_POST['post'])) {
    if ($_POST['post_cat_id'] == '' || empty($_POST['post_cat_id'])) {
        $cateerrors = "Post category is required!";
        $err = 1;
    }
    if($_POST['post_title'] == '' || empty($_POST['post_title'])){
        $titleerrors = "Post title is required!";
        $err = 1;
    }
    if($_POST['post_author'] == '' || empty($_POST['post_author'])){
        $authorerrors = "Post author is required!";
        $err = 1;
    }
    if($_POST['post_content'] == '' || empty($_POST['post_content'])){
        $contenterrors = "Post content is required!";
        $err = 1;
    }
    if($_POST['post_tag'] == '' || empty($_POST['post_tag'])){
        $tagerrors = "Post tag is required!";
        $err = 1;
    }
     if($err != 1 && isset($_FILES['post_image']['name'])){
        $filename = $_FILES['post_image']['name'];
        $tmpname = $_FILES['post_image']['tmp_name'];
        $image_type = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $fileInfo = pathinfo($filename);
        $ipath = uniqid() . '.' . $fileInfo['extension'];
        $allow_type = array('jpeg','jpg');
        if(in_array($image_type, $allow_type))
        {
        move_uploaded_file($_FILES['post_image']['tmp_name'],'./images/posts/'.$ipath);
        $date = date('Y-m-d');
        $username = $_SESSION['name'];
        $userid = $obj->loggedinUserId();
        $insertData = array(
            'post_cat_id' => mysqli_real_escape_string($obj->conn, $_POST['post_cat_id']),
            'post_title' => mysqli_real_escape_string($obj->conn, $_POST['post_title']),
            'post_author' => mysqli_real_escape_string($obj->conn, $_POST['post_author']),
            'post_user' => mysqli_real_escape_string($obj->conn, $userid),
            'post_date' => mysqli_real_escape_string($obj->conn, $date),
            'post_image' => mysqli_real_escape_string($obj->conn, $ipath),
            'post_content' => mysqli_real_escape_string($obj->conn, $_POST['post_content']),
            'post_tag' => mysqli_real_escape_string($obj->conn, $_POST['post_tag']),
        );
        $obj->insertData('tbl_posts', $insertData);
        $_SESSION['added'] = 'Post added successfully.';
        header("location: http://localhost/blogproject/admin/post.php");
        exit();
    }
    }    
}
$result = $obj->fetchAllData('tbl_category');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous"/>

</head>

<body>
    <?php include "include/header.php"; ?>
    <div id="wrapper">



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(isset($_SESSION['msg'])){?>
                            <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                                <?php echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                ?>
                            </div>
                        <?php } ?>
                        <h1 class="page-header">
                           Add Posts
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="dashboard.php">Dashboard</a>
                            </li>
                            <li class="">
                                <i class="fa fa-file"></i> <a href="post.php">Post</a>
                            </li>
                        </ol>
                    </div>

                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-8">
                        <form action="" method="POST" class="" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="" for="">Category Name</label>
                                <select name="post_cat_id" id="input" class="form-control">
                                    <option value="">Select</option>
                                    <?php foreach ($result as $row) { ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['cat_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <p style="color:red"><?php echo $cateerrors ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Title</label>
                                <input type="text" class="form-control" value="<?php echo isset($_POST["post_title"]) ? $_POST["post_title"] : ''; ?>" name="post_title" placeholder="Post Title">
                                <p style="color:red"><?php echo $titleerrors ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Author</label>
                                <input type="text" class="form-control" name="post_author" value="<?php echo isset($_POST["post_author"]) ? $_POST["post_author"] : ''; ?>" placeholder="Post Author">
                                <p style="color:red"><?php echo $authorerrors ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Image</label>
                                <input type="file" class="form-control" name="post_image" placeholder="Image" id="image">
                                <div id="preview"></div>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Tag</label>
                                <input type="text" class="form-control" name="post_tag" id="tags-input" value="<?php echo isset($_POST["post_tag"]) ? $_POST["post_tag"] : ''; ?>">
                                <p style="color:red"><?php echo $tagerrors ;?></p>
                            </div>
                            <div class="form-group">
                                <label class="" for="">Post Content</label>
                                <textarea name="post_content" id="summernote" class="form-control" rows="3" value="<?php echo isset($_POST["post_content"]) ? $_POST["post_content"] : ''; ?>" placeholder="Post Content"></textarea>
                                <p style="color:red"><?php echo $contenterrors ;?></p>
                            </div>
                            <button type="submit" name="post" class="btn btn-primary">Submit</button>
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
        $(document).ready(function() {
        var tagsValue = '';
        $("#tags-input").val(tagsValue).tagsinput();
        });
    </script>
</body>
</html>