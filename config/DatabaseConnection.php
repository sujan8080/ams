<?php
class DatabaseConnection{

    protected $conn;

    function __construct(){

        $this->conn=mysqli_connect("localhost","root","","ams");
        if ($this->conn->connect_error) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    
    
}


// $db=new DatabaseConnection();