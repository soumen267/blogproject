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


if(isset($_POST['id'])){
    $id = $_POST['id'];
    $obj->deletedata('tbl_users', 'user_id', $id);
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
                            <?php if($res1){?>
                            <small><a href="addUsers.php" class="btn btn-primary">ADD</a></small>
                            <?php }?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="dashboard.php">Dashboard</a>
                            </li>
                            <!-- <li class="">
                                <i class="fa fa-file"></i> Blank Page
                            </li> -->
                        </ol>
                    </div>
                    
                </div>
                <!-- /.row --> 
                <div class="row">
                
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-hover" id="example">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($result as $row){
                                // print_r($row);
                                // die();
                                ?>
                                <tr id="row<?php echo $row['user_id'];?>">
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
                                    <a href="userEdit.php?edit=<?php echo $row['user_id'];?>"><i class="fa fa-edit" aria-hidden="true" title="edit"></i></a>
                                    </td>
                                    <?php if($res1){?>
                                    <td>
                                    <!-- <form action="" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row['user_id'];?>">
                                        <button type="submit" name="delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form> -->
                                    <a href="javascript:void(0)" data-id="<?php echo $row['user_id'];?>" class="btndelete"><i class="fa fa-trash" aria-hidden="true" title="delete"></i></a></td>
                                    </td>
                                    <?php }else{?>
                                    <td></td>
                                    <?php } ?>
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
                url: 'users.php/'+id,
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
        $(document).ready(function () {
            var checkuser = "<?php echo $res1 ;?>";
            if(checkuser){
                let table = new DataTable('#example');
            }
        });
    </script>
</body>

</html>