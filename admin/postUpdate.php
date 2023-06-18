<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
 
require_once "../maincontroller.php";
$obj = new maincontroller();

if(ISSET($_POST['txt']) && ISSET($_POST['id'])){
    $id = $_POST['id'];
    $data = array(
        "post_status" => mysqli_real_escape_string($obj->conn, $_POST['txt'])
    );
    
    $result = $obj->updateData('tbl_posts', $data, 'id', $id);
}
?>