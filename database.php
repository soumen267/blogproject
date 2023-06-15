<?php
include "../config.php";
class database{
    private $hostname = DB_HOSTNAME;
    private $dbName = DB_NAME;
    private $username = DB_USERNAME;
    private $password = DB_USERPWD;
    public $conn;
    
    public function __construct(){
        
    try{
        if($this->conn = new mysqli($this->hostname,$this->username,$this->password,$this->dbName)){
            //echo "Connection Successful";
            return $this->conn;

        }else{
            throw new Exception('Unable to connect');
        }
    }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}
?>