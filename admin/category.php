<?php
require_once "../maincontroller.php";
session_start();
$obj = new maincontroller();
global $errors;
if(ISSET($_POST['cat_name'])){
    
    if($_POST['cat_name'] == '' || empty($_POST['cat_name'])){
        $errors = "Category field is required!";
    }else{
        $insertData = array(
        'cat_name' => mysqli_real_escape_string($obj->conn, $_POST['cat_name'])
    );
        $obj->insertData('tbl_category',$insertData);
    }
    
    
}
$result = $obj->fetchAllData('tbl_category');

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $catedit = $obj->fetchDataByID('tbl_category', 'id', $id);
    
}
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $data = array(
        'cat_name' => mysqli_real_escape_string($obj->conn, $_POST['cat_name'])
    );
    
    $cat_update = $obj->updateData('tbl_category',$data,'id',$id);
    header('location: http://localhost/blogproject/admin/category.php');
}
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $obj->deletedata('tbl_category', 'id', $id);
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
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css" />
    <style>
        .btndelete{
            border: none;
            background: none;
            color: red;
        }
        .btndelete:hover {
            color: red;
            transition: 0.7s;
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
                        <h1 class="page-header">
                            Category
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
                <?php if(isset($_GET['edit'])){?>
                <div class="col-lg-6">
                <p>Edit</p>
                            <p style="color:red;"><?php echo $errors; ?></p>
                    
                        <form action="" method="POST" class="form-inline" role="form">
                            <div class="form-group">
                                <label class="sr-only" for="">label</label>
                                <?php foreach($catedit as $row){?>
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                
                                <input type="text" class="form-control" name="cat_name" value="<?php echo $row['cat_name'] ?>" placeholder="Category Name">
                                <?php } ?>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                        </form>
                        
                </div>
                <div class="row">
                <?php }else{?>
                <div class="col-lg-6">
                        <p style="color:red;"><?php echo $errors; ?></p>
                   
                    <form action="" method="POST" class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="">label</label>
                            <input type="text" class="form-control" name="cat_name" placeholder="Category Name">
                        </div>
                        <button type="submit" name="cat-btn" class="btn btn-primary">Add</button>
                    </form>
                    
                </div>
                <?php } ?>
                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Name</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result as $row){?>
                                <tr id="row<?php echo $row['id'];?>">
                                    <td><?php echo $row['id'];?></td>
                                    <td><?php echo $row['cat_name'];?></td>
                                    <td>
                                    <a href="category.php?edit=<?php echo $row['id'];?>"><i class="fa fa-edit" aria-hidden="true" title="edit"></i></a></td>
                                    <td>
                                    <!-- <form action="" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                                        <button type="submit" name="delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form> -->
                                    <a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" class="btndelete"><i class="fa fa-trash" aria-hidden="true" title="delete"></i></a></td>
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
                url: 'category.php/'+id,
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
</body>

</html>