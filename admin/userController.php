<?php
require_once "database.php";

class userController extends database{

    public function insertUserData($table_name,$data){
        $items = "";
        $values = "";
        foreach ($data as $keys => $value){
            $items .= '`'.$keys.'`,';
            $values .= "'".$value."',"; 
        }
        $string = "INSERT INTO ".$table_name." (".rtrim($items, ",").") VALUES (".rtrim($values, ",").")";
        if(mysqli_query($this->conn, $string)){
            return true;
        }else{
            mysqli_error($this->conn);
        }
    }

    public function login($table_name,$uname,$upwd){
        $res = "SELECT * FROM $table_name WHERE `username` = '$uname' AND `password` = '$upwd'";
        $res = mysqli_query($this->conn, $res);
        if(mysqli_num_rows($res) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function updatePostData($table_name, $data, $id){
        foreach ($data as $keys => $value){
            $studentEditData = "UPDATE $table_name SET $keys = '$value' WHERE `user_id` = $id";
            $res = $this->conn->query($studentEditData);
            // print_r($studentEditData);
            // die();
        }
        
        // echo $res;
        // die;
        if($res == TRUE){
        //echo $res;
            return $res;
        }else{
            return false;
            echo "Error updating record: " . $this->conn->error;

        }
    }

    public function fetchAllUsers($table_name){
        $sql = "SELECT * FROM $table_name WHERE `deleted_at` IS NULL";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }

    public function fetchUsersByID($table_name, $id){
        $sql = "SELECT * FROM $table_name WHERE `user_id` = $id";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }

    public function deleteuser($table_name, $id){
        $time = date("Y-m-d H:i:s");
        $dataDelete = "UPDATE $table_name SET `deleted_at` = '$time' WHERE `user_id` = '$id'";
        $res = $this->conn->query($dataDelete);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    function countData($tablename){
        $sql = "SELECT * FROM $tablename";
        $res = $this->conn->query($sql);
        $count = mysqli_num_rows($res);
        if($count > 0){
            return $count;
        }else{
            return false;
        }
    }

}
?>