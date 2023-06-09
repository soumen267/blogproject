<?php
require_once "postController.php";

$obj = new postController();
global $errors;

$result = $obj->fetchAllPosts('tbl_posts', 'tbl_category');

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
                                <tr>
                                    <td><?php echo $row['id'];?></td>
                                    <td><?php echo $row['cat_name'];?></td>
                                    <td><?php echo $row['post_title'];?></td>
                                    <td><?php echo $row['post_author'];?></td>
                                    <td><?php echo $row['post_user'];?></td>
                                    <td><?php echo $row['post_date'];?></td>
                                    <td>                                    
                                    <img src="./images/posts/<?php echo $row['post_image'];?>" class="img-responsive" style="height:42px;width:71px;" alt="Image">
                                    </td>
                                    <td><?php echo htmlentities(substr($row['post_content'],1,20));?></td>
                                    <td><?php echo $row['post_tag'];?></td>
                                    <td><?php echo $row['post_comment_count'];?></td>
                                    <td><?php echo $row['post_status'];?></td>
                                    <td><?php echo $row['post_view_count'];?></td>
                                    <td>
                                    <a href="postEdit.php?edit=<?php echo $row['id'];?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                                    <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                                        <button type="submit" name="delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
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

</body>

</html>