<?php
require_once "database.php";
class blogcontroller extends database{

    public function categoryinsert($table_name,$data){
        $items = "";
        $values = "";
        foreach ($data as $keys => $value){
            $items .= '`'.$keys.'`,';
            $values .= "'".$value."',"; 
        }
        $string = "INSERT INTO ".$table_name." (".rtrim($items, ",").") VALUES (".rtrim($values, ",").")";
        if(mysqli_query($this->conn, $string)){
            return true;
            header("location: http://localhost/blogproject/admin/category.php");
        }else{
            mysqli_error($this->conn);
        } 
    }

    public function fetchCategoryAll($table_name){
        $categoryData = "SELECT * FROM $table_name";
        $res = $this->conn->query($categoryData);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function edit($table_name, $id){
        $categoryEditData = "SELECT * FROM $table_name WHERE `id` = $id";
        $res = $this->conn->query($categoryEditData);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function update($table_name, $data, $id){
        foreach ($data as $keys => $value){
            $catEditData = "UPDATE $table_name SET $keys = '$value' WHERE `id` = '$id'";
        }
        $res = $this->conn->query($catEditData);
        if($res){
            return $res;
            echo $res;
            //header("Refresh:1; http://localhost/blogproject/admin/category.php", true, 303);
        }else{
            return false;
        }
    }


}
?>