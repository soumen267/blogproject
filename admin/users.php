<?php
session_start();
include "../maincontroller.php";

$obj = new maincontroller();

$username = $obj->loggedinUsername();
$res1 = $obj->isAdmin('tbl_users',$username);
if(!$res1){
    $result = $obj->fetchLoggedInUser('tbl_users',$username);
}else{
    $result = $obj->fetchAllData('tbl_users');
    
}


if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $obj->deletedata('tbl_users', 'user_id', $id);
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
    <style>
        btn{
            background-color: red;
            border: none;
            /* color: red; */
            padding: 5px 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 20px;
        }
        .green{
            background-color: #199319;
        }
        .red{
            background-color: red;
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
                            Users
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
                
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Image</th>
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
                                    <td><?php echo $row['user_id'];?></td>
                                    <td><?php echo $row['username'];?></td>
                                    <td><?php echo $row['user_firstname'];?></td>
                                    <td><?php echo $row['user_lastname'];?></td>
                                    <td><?php echo $row['user_email'];?></td>
                                    <td><?php echo $row['user_role'];?></td>
                                    <td>                                    
                                    <img src="./images/users/<?php echo $row['user_image'];?>" class="img-responsive" style="height:42px;width:71px;" alt="Image">
                                    </td>
                                    <!-- <td>
                                    <--?php if($row['status'] != 1){
                                        echo 
                                        "<a href=deactivate.php?id=".$row['user_id']." class='btn red'>Deactivate</a>";
                                    }else{ 
                                        echo 
                                        "<a href=activate.php?id=".$row['user_id']." class='btn green'>Activate</a>";
                                    }                                   
                                    ?>
                                    </td> -->
                                    <td>
                                    <a href="userEdit.php?edit=<?php echo $row['user_id'];?>"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                                    <?php if($res1){?>
                                    <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row['user_id'];?>">
                                        <button type="submit" name="delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form>
                                    </td>
                                    <?php }?>
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