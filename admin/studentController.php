<?php
require_once "database.php";
session_start();

class studentController extends database{

    public function insertData($table_name,$data){
        $items = "";
        $values = "";
        foreach ($data as $keys => $value){
            $items .= '`'.$keys.'`,';
            $values .= "'".$value."',"; 
        }
        $string = "INSERT INTO ".$table_name." (".rtrim($items, ",").") VALUES (".rtrim($values, ",").")";
        // $string = "INSERT INTO ".$table_name." (";
        // $string .= implode(",", array_keys($data)) . ') VALUES (';
        // $string .= "'" . implode("','", array_values($data)) . "')";
        if(mysqli_query($this->conn, $string)){
            return true;
        }else{
            mysqli_error($this->conn);
        }
    }

    public function fetchData($table_name){
        $studentData = "SELECT * FROM $table_name";
        $res = $this->conn->query($studentData);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function edit($table_name, $id){
        $studentEditData = "SELECT * FROM $table_name WHERE `ID` = $id";
        $res = $this->conn->query($studentEditData);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function update($table_name, $data, $id){
        foreach ($data as $keys => $value){
            $studentEditData = "UPDATE $table_name SET $keys = $value WHERE `ID` = $id";
        }
        $res = $this->conn->query($studentEditData);
        if($res){
            return $res;
        }else{
            return false;
        }
    }

    public function delete($table_name, $id){
        $dataDelete = "DELETE FROM $table_name WHERE `ID` = '$id' LIMIT 1";
        $res = $this->conn->query($dataDelete);
        if($res){
            return true;
        }else{
            return false;
        }
    }

    public function logout(){
        session_destroy();
        header("location: http://localhost/blogproject/admin/");
    }
}
?>