<?php
include_once "../admin/database.php";
class maincontroller extends database{

    public function fetchCategory($tablename){
        $sql = "SELECT * FROM $tablename";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function fetchAllPosts($tablename){
        $sql = "SELECT * FROM $tablename";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
    }

}
?>