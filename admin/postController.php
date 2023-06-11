<?php
include_once("database.php");
include_once "../helper.php";
class postController extends database{

    public function insertPostData($table_name,$data){
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

    public function fetchByCategory($table_name){
        $sql = "SELECT * FROM $table_name";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }

    public function fetchAllPosts($table_name, $foreign_table_name, $foreign_table_name1, $name){
        $sql2 = "SELECT `user_role` FROM $foreign_table_name1 WHERE `username` = '$name'";
        $res2 = $this->conn->query($sql2);
        if(mysqli_num_rows($res2) > 0){
            foreach($res2 as $val){
                $user_role = implode(",",$val);
            }
        }

        $sql1 = "SELECT `user_id` FROM $foreign_table_name1 WHERE `username` = '$name'";
        $res1 = $this->conn->query($sql1);
        if(mysqli_num_rows($res1) > 0){
            foreach($res1 as $val){
                $user_id = implode(",",$val);
            }
        }
        if($user_role != 'admin'){
        $sql = "SELECT $foreign_table_name.cat_name,
                $table_name.id,
                $table_name.post_title,
                $table_name.post_author,
                $table_name.post_user,
                $table_name.post_date,
                $table_name.post_image,
                $table_name.post_content,
                $table_name.post_tag,
                $table_name.post_status,
                $table_name.post_comment_count,
                $table_name.post_view_count,
                $foreign_table_name1.username AS username
                FROM $table_name
                INNER JOIN $foreign_table_name
                ON $table_name.post_cat_id = $foreign_table_name.id
                INNER JOIN $foreign_table_name1
                ON $table_name.post_user = $foreign_table_name1.user_id
                WHERE $table_name.post_user = $user_id AND
                $table_name.deleted_at IS NULL";
        }else{
            $sql = "SELECT $foreign_table_name.cat_name,
                $table_name.id,
                $table_name.post_title,
                $table_name.post_author,
                $table_name.post_user,
                $table_name.post_date,
                $table_name.post_image,
                $table_name.post_content,
                $table_name.post_tag,
                $table_name.post_status,
                $table_name.post_comment_count,
                $table_name.post_view_count,
                $foreign_table_name1.username AS username
                FROM $table_name
                INNER JOIN $foreign_table_name
                ON $table_name.post_cat_id = $foreign_table_name.id
                INNER JOIN $foreign_table_name1
                ON $table_name.post_user = $foreign_table_name1.user_id WHERE
                $table_name.deleted_at IS NULL";
        }   
        $res = $this->conn->query($sql);
        //print_r($res);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }
    public function fetchPostsByID($table_name, $foreign_table_name, $id){
        $sql = "SELECT $foreign_table_name.cat_name,
                $foreign_table_name.id AS fid,
                $table_name.id,
                $table_name.post_title,
                $table_name.post_author,
                $table_name.post_user,
                $table_name.post_date,
                $table_name.post_image,
                $table_name.post_content,
                $table_name.post_tag,
                $table_name.post_status,
                $table_name.post_comment_count,
                $table_name.post_view_count
                FROM $table_name
                INNER JOIN $foreign_table_name
                ON $table_name.post_cat_id = $foreign_table_name.id
                WHERE $table_name.id = $id";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }

    public function updatePostData($table_name, $data, $id){
        foreach ($data as $keys => $value){
            $studentEditData = "UPDATE $table_name SET $keys = '$value' WHERE `id` = $id";
            $res = $this->conn->query($studentEditData);
        }
        if($res == TRUE){
            return $res;
        }else{
            return false;
            echo "Error updating record: " . $this->conn->error;

        }
    }

    function deleteData($tablename, $id){
        $date = date("Y-m-d H:i:s");
        $sql = "UPDATE $tablename SET `deleted_at` = '$date' WHERE `id` = $id";
        $res = $this->conn->query($sql);
        if($res == TRUE){
            return $res;
            echo "Deleted: " . $id;
          }else{
            return false;
            echo "Error updating record: " . $this->conn->error;
    
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
}
?>