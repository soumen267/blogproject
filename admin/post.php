<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
session_start();
require_once "postController.php";

$obj = new postController();
global $errors;

$name = $_SESSION['name'];
$result = $obj->fetchAllPosts('tbl_posts', 'tbl_category', 'tbl_users', $name);

if(ISSET($_POST['id'])){
    $id = $_POST['id'];
    $result = $obj->deleteData('tbl_posts', $id);
    echo "Deleted:";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
<style>
.btndelete{
    border: none;
    background: none;
    color: red;
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
                        <?php if(isset($_SESSION['msg'])){?>
                            <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                                <?php echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                ?>
                            </div>
                        <?php }elseif(isset($_SESSION['added'])){ ?>
                            <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                                <?php echo $_SESSION['added'];
                                    unset($_SESSION['added']);
                                ?>
                            </div>
                        <?php } ?>
                        <h1 class="page-header">
                            Posts
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
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Category Name</th>
                                    <th>Post Title</th>
                                    <th>Post Author</th>
                                    <th>Post User</th>
                                    <th>Post Date</th>
                                    <th>Post Image</th>
                                    <th>Post Content</th>
                                    <th>Post Tag</th>
                                    <th>Post Comment Count</th>
                                    <th>Post Status</th>
                                    <th>Post View Count</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result as $row){
                                // print_r($row);
                                // die();
                                ?>
                                <tr id="row<?php echo $row['id'];?>">
                                    <td><?php echo $row['id'];?></td>
                                    <td><?php echo $row['cat_name'];?></td>
                                    <td><?php echo $row['post_title'];?></td>
                                    <td><?php echo $row['post_author'];?></td>
                                    <td><?php echo $row['username'];?></td>
                                    <td><?php echo $row['post_date'];?></td>
                                    <td>                                    
                                    <img src="./images/posts/<?php echo $row['post_image'];?>" class="img-responsive" style="height:42px;width:71px;" alt="Image">
                                    </td>
                                    <td><?php echo htmlentities(substr($row['post_content'],0,10));?></td>
                                    <td><?php echo $row['post_tag'];?></td>
                                    <td><?php echo $row['post_comment_count'];?></td>
                                    <td><?php echo $row['post_status'];?></td>
                                    <td><?php echo $row['post_view_count'];?></td>
                                    <td>
                                    <a href="postEdit.php?edit=<?php echo $row['id'];?>"><i class="fa fa-edit" aria-hidden="true" title="edit"></i></a></td>
                                    <td>
                                    <a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" class="btndelete"><i class="fa fa-trash" aria-hidden="true" title="delete"></i></a></td>
                                    <!-- <form action="" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                                        <button type="submit" name="delete" id="btndelete"><i class="fa fa-trash" aria-hidden="true" title="delete"></i></button>
                                    </form> -->
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
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
         $(".btndelete").click(function(){
            //var id = $(this).parents("tr").attr("id");
            var id = $(this).data("id");

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            },

            function(isConfirm) {
            if (isConfirm) {
            
            $.ajax({
                url: 'post.php/'+id,
                type: 'POST',
                data: {"id":id},
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    $("#row"+id).remove();
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    //location.reload();
                }
            });

            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
            });
        });
</script>
<script>
// $("document").ready(function(){
//     setTimeout(function(){
//        $("div.alert").remove();
//     }, 5000 ); // 5 secs

// });
</script>
</body>

</html>