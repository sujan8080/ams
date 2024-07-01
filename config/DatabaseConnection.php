<?php
class DatabaseConnection{

    
    protected $conn;

    function __construct(){

        $this->conn=mysqli_connect("localhost","root","","");
        if($this->conn){
            // return $this->conn;
            echo "DAtabase connection";
        }
    }
    
    
}


// $db=new DatabaseConnection();





