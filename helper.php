<?php
require_once "../admin/database.php";
$obj = new database();
// function message($msg){
//     $ms = '<div class="alert alert-success alert-block">
//             <button type="button" class="close" data-dismiss="alert">x</button>
//             echo $msg;
//             </div>';
//     return $ms;
// }

// function isUserName($username){
//     $sql = "SELECT `user_id` FROM `tbl_users` WHERE `username` = '$username'";
//     $res = $this->conn->query($sql);
//     if(mysqli_num_rows($res) > 0){
//         foreach($res as $val){
//             $userid = implode(",",$val);
//         }
//         if($userid){
//             return $userid;
//         }else{
//             return false;
//         }
//     }
// }

?>