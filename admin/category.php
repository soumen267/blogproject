<?php
require_once "blogcontroller.php";

$obj = new blogcontroller();
global $errors;
if(ISSET($_POST['cat_name'])){
    
    if($_POST['cat_name'] == '' || empty($_POST['cat_name'])){
        $errors = "Category field is required!";
    }else{
        $insertData = array(
        'cat_name' => mysqli_real_escape_string($obj->conn, $_POST['cat_name'])
    );
        $obj->categoryinsert('tbl_category',$insertData);
    }
    
    
}
$result = $obj->fetchCategoryAll('tbl_category');

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $catedit = $obj->edit('tbl_category', $id);
    // foreach($catedit as $row){
    //     $cat_name = $row['cat_name'];
    // }
    
}
if(isset($_POST['update'])){
    $id = $_GET['edit'];
    $data = array(
        'cat_name' => mysqli_real_escape_string($obj->conn, $_POST['cat_name'])
    );
    
    $cat_update = $obj->update('tbl_category',$data,$id);
    
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
                            Category
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
                <div class="col-lg-6">
                        <p style="color:red;"><?php echo $errors; ?></p>
                   
                    <form action="" method="POST" class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="">label</label>
                            <input type="text" class="form-control" name="cat_name" id="" placeholder="Category Name">
                        </div>
                        <button type="submit" name="cat-btn" class="btn btn-primary">Submit</button>
                    </form>
                    
                </div>
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
                                <tr>
                                    <td><?php echo $row['id'];?></td>
                                    <td><?php echo $row['cat_name'];?></td>
                                    <td>
                                    <a href="category.php?edit=<?php echo $row['id'];?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
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
            <?php if(isset($_GET['edit'])){?>
            <div class="row">
            <div class="col-lg-3">
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
            </div>
            <?php } ?>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <?php include "include/footer.php" ?>

</body>

</html>