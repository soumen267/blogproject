<?php
include_once "../admin/database.php";
class maincontroller extends database{

    public function userlogin($table_name,$uname,$upwd){
        $res = "SELECT * FROM $table_name WHERE `username` = '$uname' AND `password` = '$upwd'";
        $res = mysqli_query($this->conn, $res);
        if(mysqli_num_rows($res) > 0){
            return true;
        }else{
            return false;
        }
    }

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

    public function fetchPostsByID($tablename, $id){
        $sql = "SELECT * FROM $tablename WHERE `id` = $id";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
    }

    public function addComment($table_name,$data){
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

    public function fetchCommentsByPostID($tablename,$foreigntable,$id){
        $sql = "SELECT $foreigntable.post_title,$foreigntable.post_image,
                $tablename.id,
                $tablename.post_id AS postid,
                $tablename.comment_content AS comment_content,
                $tablename.created_at AS created_at
                FROM $tablename
                INNER JOIN $foreigntable
                ON $foreigntable.id = $tablename.post_id
                WHERE $foreigntable.id = $id";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }

    }

    function getUserID($tablename,$username){
        $sql = "SELECT `user_id` FROM $tablename WHERE `username` = '$username'";
        $res = $this->conn->query($sql);
        if(mysqli_num_rows($res) > 0){
            foreach($res as $val){
                $user_id = implode(",",$val);
                return $user_id;
            }
        }
    }

    public function canEditComment($table_name, $userid,$id){
        $sql = "SELECT * FROM $table_name WHERE `post_user` = '$userid' AND `id` = $id";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }

    public function logout(){
       session_destroy();
       header("location: http://localhost/blogproject/blogproject/users/");
    }
}
?>