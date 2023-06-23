<?php 
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
  use PHPMailer\PHPMailer\PHPMailer;

	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer-master/src/Exception.php';

	require 'PHPMailer-master/src/PHPMailer.php';

	require 'PHPMailer-master/src/SMTP.php'; 
include_once "maincontroller.php";
$obj = new maincontroller();
global $emailerr;
if(isset($_POST['recover-submit'])){
$email = $obj->emailExists($_POST['email']);
$emails = $_POST['email'];
if($email){
            //$length = 50;
            //$token = bin2hex(openssl_random_pseudo_bytes($length));
         $otp = rand(100000, 999999); //generates random otp
         $_SESSION['session_otp'] = $otp;
         $_SESSION['email'] = $emails;
   	     $mail = new PHPMailer();

          $mail->isSMTP();                                      // Set mailer to use SMTP

          $mail->Host = 'sandbox.smtp.mailtrap.io';  // Specify main and backup SMTP servers

          $mail->SMTPAuth = true;                               // Enable SMTP authentication

          $mail->Username = '9c09f09fa5b734';                // SMTP username

          $mail->Password = '8d933d018c76f9';       // SMTP password

          $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted

          $mail->Port = 2525;                                    // TCP port to connect to

          //Recipients

          $mail->setFrom('info@mailtrap.io' ,'Test');

          $mail->addAddress('recipient1@mailtrap.io');  

          $mail->isHTML(true);  
  //         $email_template = './mail/index.html';
          // $mail->Body = '<p>Please click to reset your password

          //     <a href="http://localhost/blogproject/reset.php?email='.$emails.'&token='.$token.' ">http://localhost/blogproject/reset.php?email='.$emails.'&token='.$token.'</a>

          //   </p>'; 
         $mail->Body = '<p>Your one time email verification code is '.$otp.'
         </p>'; 
          //$message = file_get_contents($email_template);
          $message = "Your one time email verification code is" . $otp;

          //$mail->MsgHTML($message);  

          $mail->Subject = 'Email verification from MyBlog';

          if (!$mail->send())

          {

            $emailerr = 'Mailer Error: ' . $mail->ErrorInfo;

          }

          else

            {

              $emailerr = "mail send 📨";

            }
  }else{
    $emailerr = "Email does not exists";
  }


}
if(isset($_POST["otp-submit"])){
  if($_POST["otp"] == $_SESSION['session_otp']){
    unset($_SESSION['session_otp']);
    $emailerr = "Success!";
    header("Location: http://localhost/blogproject/reset.php?ver");
  }else{
    $emailerr = "Invalid OTP please try again!";
  }
}

?>
<!-- Page Content -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="./users/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
  <link href="./users/css/blog-post.css" rel="stylesheet">
</head>
<body>
<div class="container">
<?php include "./users/include/header.php"?>
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                       <?php if(!isset($_SESSION['session_otp'])){?>
                         <div class="text-center">


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h4 style="color:red"><?php echo $emailerr; ?></h4>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control" type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                        <?php }else{?>
                          <h3><i class="fa fa-lock fa-4x"></i></h3>
                          <h4 style="color:red" class="text-center"><?php echo $emailerr; ?></h4>
                          <h2 class="text-center"></h2>
                          <p>Please enter your OTP here.</p>
                          <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                    <input id="otp" name="otp" placeholder="Enter you OTP" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <input name="otp-submit" class="btn btn-lg btn-primary btn-block" value="Verify" type="submit">
                            </div>
                            </form>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- /.container -->  
</body>
</html>
