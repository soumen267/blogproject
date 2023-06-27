<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .active{
        background-color: black;
        color: whitesmoke!important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand <?= ($activePage == 'index') ? 'active':''; ?>" href="http://localhost/blogproject/users/">Home</a>
                <a class="navbar-brand <?= ($activePage == 'about') ? 'active':''; ?>" href="javascript:void(0)">About</a>
                <a class="navbar-brand <?= ($activePage == 'services') ? 'active':''; ?>" href="javascript:void(0)">Services</a>
                <a class="navbar-brand <?= ($activePage == 'contact') ? 'active':''; ?>" href="javascript:void(0)">Contact</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
                <?php if(isset($_SESSION['uname'])){?>
                <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                    <?php
                        if(isset($_SESSION['uname']))
                        {
                        echo ucfirst($_SESSION['uname']);
                        }
                    ?>
                    <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="../admin/dashboard.php" target="__blank"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <!-- <li>
                            <a href="java"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li> -->
                        <!-- <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li> -->
                        <li class="divider"></li>
                        <li>
                            <form action="" method="post">
                            <button type="submit" name="logout" class="log-botton"><i class="fa fa-fw fa-power-off"></i> Log Out</button>
                            </form>
                        </li>
                    </ul>
                </li>
                </ul>
                <?php }?>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>    
</body>
</html>
