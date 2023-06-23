<?php
require_once "database.php";
class maincontroller extends database{

    public function login($table_name,$type,$uname,$upwd){
        $res = "SELECT * FROM $table_name WHERE `username` = '$uname' AND `password` = '$upwd'";
        $res = mysqli_query($this->conn, $res);
        if(mysqli_num_rows($res) > 0){
            // if($type=="users"){
            //     $_SESSION['uname']=$uname;
            // }elseif($type=="admin"){
            //     $_SESSION['name']=$uname;
            // }
            return true;
        }else{
            return false;
        }
    }

    public function insertData($table_name,$data){
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

    public function fetchAllPosts($table_name, $foreign_table_name, $foreign_table_name1, $name){
        $user_role = $this->loggedInUserRole($foreign_table_name1, $name);
        $user_id = $this->loggedinUserId();
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
                $table_name.deleted_at IS NULL
                ORDER BY $table_name.id";
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
                $table_name.deleted_at IS NULL
                ORDER BY $table_name.id
                ";
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
        $sql = "SELECT $foreign_table_name.cat_name AS cname,
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
                $table_name.post_view_count,
                $table_name.created_at
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
    
    public function fetchAllData($table_name){
        $sql = "SELECT * FROM $table_name WHERE `deleted_at` IS NULL";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }
    
    public function fetchAllPostData($table_name){
        $sql = "SELECT * FROM $table_name WHERE `deleted_at` IS NULL AND `post_status` = 'Published'";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }

    public function fetchDataByID($table_name, $column_name, $id){
        $sql = "SELECT * FROM $table_name WHERE $column_name = $id";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
        
    }

    

    public function updateData($table_name, $data, $column,$id){
        foreach ($data as $keys => $value){
            $studentEditData = "UPDATE $table_name SET $keys = '$value' WHERE $column = $id";
            $res = $this->conn->query($studentEditData);
        }
        if($res == TRUE){
            return $res;
        }else{
            return false;
            echo "Error updating record: " . $this->conn->error;

        }
    }

    public function updatedData($table_name, $data, $column,$id){
        foreach ($data as $keys => $value){
            $studentEditData = "UPDATE $table_name SET $keys = '$value' WHERE $column = '$id'";
            $res = $this->conn->query($studentEditData);
        }
        if($res == TRUE){
            return $res;
        }else{
            return false;
            echo "Error updating record: " . $this->conn->error;

        }
    }

    public function deletedata($table_name, $columnname, $id){
        $time = date("Y-m-d H:i:s");
        $dataDelete = "UPDATE $table_name SET `deleted_at` = '$time' WHERE $columnname = '$id'";
        $res = $this->conn->query($dataDelete);
        if($res){
            return true;
        }else{
            return false;
        }
    }
    public function logout(){
        $users = $this->loggedinUsername();
        $sql = "SELECT `user_role` FROM `tbl_users` WHERE `username` = '$users'";
        $res = $this->conn->query($sql);
        if(mysqli_num_rows($res) > 0){
            foreach($res as $val){
                $role = implode(",",$val);
            }
            if($role == 'user'){
                session_destroy();
                header("location: http://localhost/blogproject/users/");
            }elseif($role == 'admin'){
                session_destroy();
                header("location: http://localhost/blogproject/admin/");
            }
        }
    }
    // Some helper function
    function fetchLoggedInUser($table_name, $username){
        $sql = "SELECT * FROM $table_name WHERE `username` = '$username'";
        $res = $this->conn->query($sql);
        if($res->num_rows > 0){
            return $res;
        }else{
            return false;
        }
    }

    function loggedinUsername(){
        if(isset($_SESSION['name'])){
            return $_SESSION['name'];
        }elseif(isset($_SESSION['uname'])){
            return $_SESSION['uname'];
        }else{
            return false;
        }        
    }

    function loggedinUserId(){
        $uname = $this->loggedinUsername();
        $sql = "SELECT `user_id` FROM `tbl_users` WHERE `username` = '$uname'";
        $res = $this->conn->query($sql);
        if(mysqli_num_rows($res) > 0){
            foreach($res as $val){
                $user_id = implode(",",$val);
                return $user_id;
            }
            return false;
        }
    }
    function loggedInUserRole($foreign_table_name1, $name){
        $sql2 = "SELECT `user_role` FROM $foreign_table_name1 WHERE `username` = '$name'";
        $res2 = $this->conn->query($sql2);
        if(mysqli_num_rows($res2) > 0){
            foreach($res2 as $val){
                $user_role = implode(",",$val);
                return $user_role;
            }
        }
        return false;
    }

    function isAdmin($tablename,$username){
        $sql = "SELECT `user_role` FROM $tablename WHERE `username` = '$username'";
        $res = $this->conn->query($sql);

        if(mysqli_num_rows($res) > 0){
            foreach($res as $val){
                $role = implode(",",$val);
            }
            if($role == 'user'){
                return false;
            }elseif($role == 'admin'){
                return true;
            }
        }
    }

    function usernameExists($username){
        $sql = "SELECT `username` FROM `tbl_users` WHERE `username` = '$username'";
        $res = $this->conn->query($sql);
        if(mysqli_num_rows($res) > 0){
            return true;
        }else{
            return false;
        }
    }

    function emailExists($email){
        $sql = "SELECT `user_email` FROM `tbl_users` WHERE `user_email` = '$email'";
        $res = $this->conn->query($sql);
        if(mysqli_num_rows($res) > 0){
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

    function countDataByColumn($tablename, $columnname,$columvalue){
        $sql = "SELECT * FROM $tablename WHERE $columnname = '$columvalue'";
        $res = $this->conn->query($sql);
        $count = mysqli_num_rows($res);
        if($count > 0){
            return $count;
        }else{
            return false;
        }
    }

    function countDataById($tablename, $columnname, $id){
        $sql = "SELECT * FROM $tablename WHERE $columnname = $id";
        $res = $this->conn->query($sql);
        $count = mysqli_num_rows($res);
        if($count > 0){
            return $count;
        }else{
            return false;
        }
    }

    // function redirectIfNotLogin(){
    //     if(!isset($_SESSION['name'])){
    //         header("Location: http://localhost/blogproject/admin/");
    //         exit();
    //     }
    // }

    function customQuery($tablename, $column = NULL){
        $sql = "SELECT $column FROM $tablename";
        $res = $this->conn->query($sql);
        if(mysqli_num_rows($res) > 0){
            foreach($res as $val){
                $col = implode(",",$val);
                return $col;
            }
        }
        return false;
    }

}
?>